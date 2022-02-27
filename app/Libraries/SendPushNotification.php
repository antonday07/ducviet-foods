<?php

namespace App\Libraries;

use App\Models\UserDevice;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\Models\UserDevices;
use Exception;
use LaravelFCM\Message\Topics;
use FCM;
class SendPushNotification
{
    public function buildMessage($title, $message, $data = [], $badge = 1)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 40);
        $optionBuilder->setPriority('high');

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
            ->setSound('sound')
            ->setBadge($badge);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);
        $optionBuilder->setContentAvailable(1);
        //$optionBuilder->setDelayWhileIdle(true);
        //$optionBuilder->setMutableContent(1);
        $option = $optionBuilder->build();

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        return [
            'notification' => $notification,
            'options' => $option,
            'data' => $data,
        ];
    }

    public function sendToDevice($token, $title, $message, $data = [], $badge = 1)
    {
        // var_dump($token);
        $build = $this->buildMessage($title, $message, $data, $badge);
        // dd($token);
        $downstreamResponse = \FCM::sendTo($token, $build['options'], $build['notification'], $build['data']);

        // dd($downstreamResponse);
        $numberSuccess = $downstreamResponse->numberSuccess();
        $numberFailure = $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        \Log::debug("numberSuccess : $numberSuccess");
        \Log::debug("numberFailure : $numberFailure");

        if (!empty($numberFailure)) {
            UserDevice::where('token', $token)->delete();
            return false;
        }

        return [
            'notification' => $build['notification']->toArray(),
            'options' => $build['options']->toArray(),
            'data' => $build['data']->toArray(),
        ];
    }

    public function sendToTopic($topic, $title, $message, $data = [], $badge = 1)
    {
        $build = $this->buildMessage($title, $message, $data, $badge);

        $topic = new Topics();
        $topic->topic($topic);

        $topicResponse = FCM::sendToTopic($topic, $build['options'], $build['notification'], $build['data']);

        $topicResponse->isSuccess();
        $topicResponse->shouldRetry();
        $topicResponse->error();

        return true;
    }

    public function sendToGroup($groupToken, $title, $message, $data = [], $badge = 1)
    {
        $build = $this->buildMessage($title, $message, $data, $badge);
        $groupResponse = FCM::sendToGroup($groupToken, $build['options'], $build['notification'], $build['data']);

        $numberSuccess = $groupResponse->numberSuccess();
        $numberFailure = $groupResponse->numberFailure();
        $tokenFailed = $groupResponse->tokensFailed();
        \Log::debug("numberSuccess : $numberSuccess");
        \Log::debug("numberFailure : $numberFailure");

        if (!empty($numberFailure)) {
            UserDevice::whereIn('token', $tokenFailed)->delete();
        }

        return [
            'notification' => $build['notification']->toArray(),
            'options' => $build['options']->toArray(),
            'data' => $build['data']->toArray(),
            'numberFailure' => $numberFailure
        ];
    }

    public function sendVoiceToDevice($deviceToken, $data, $type = 0)
    {
        try {
            $server = 'ssl://gateway.sandbox.push.apple.com:2195';
            $configPem = resource_path('configs/ios_certificate_parent.pem');
            $passphrase = '';

            if (env('APP_ENV', 'local') === 'production') {
                $server = 'ssl://gateway.push.apple.com:2195';
            }
            \Log::info("File .pem:  $configPem");
            \Log::info("Push Voip to token $deviceToken");

            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $configPem);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            // Open a connection to the APNS server

            $fp = stream_socket_client(
                $server,
                $err,
                $errstr,
                60,
                STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT,
                $ctx
            );

            if (!$fp) {
                throw new \Exeption("Failed to connect: $err $errstr", 500);
            }

            \Log::info('Connected to APNS');

            // Create the payload body
            $body['data'] = $data;
            $body['aps'] = array(
                'content-available' => 1,
                // 'alert' => '',
                'sound' => 'default',
                'badge' => 0,
            );

            // Encode the payload as JSON

            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));

            if (!$result) {
                \Log::info('Message not delivered');
            } else {
                \Log::info('Message successfully delivered: ' . $deviceToken);
            }

            // Close the connection to the server
            fclose($fp);
            return true;
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return false;
        }
    }

    public function sendCloudMessaseToAndroid($deviceToken = "", $title = "", $pushData = array())
    {
        $url = 'https://fcm.googleapis.com/fcm/send ';
        $serverKey = env('FCM_SERVER_KEY');
        \Log::info('Server KEY--------------');
        \Log::debug($serverKey);
        $msg = array(
            'title' => $title,
            'data'  => $pushData,
            'sound' => 'default'

        );
        $fields = array();
        $fields['data'] = $msg;
        $fields['priority'] = 'high';
        $fields['content_available'] = true;
        $fields['time_to_live'] = 2400;
        if (is_array($deviceToken)) {
            $fields['registration_ids'] = $deviceToken;
        } else {
            $fields['to'] = $deviceToken;
        }
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $serverKey
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($curl);
        if ($result === false) {
            throw new Exception('FCM Send Error: '  .  curl_error($curl));
        }
        curl_close($curl);
        return $result;
    }
}
