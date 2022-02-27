<?php

namespace App\Libraries;

use Carbon\Carbon;
use File;
use App\Jobs\SavePushNotification;
use App\Jobs\SendPushChat;
use App\Models\RequestCounselor;
use Braintree;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

use Symfony\Component\HttpFoundation\Response;

class Ultilities
{
    /**
     * get min by date from and date to
     * @author lamnt
     * @param date now, dateto
     * @date 2021 04 01
     */
    public static function getMin($date_to, $time = 0)
    {
        $from_time = strtotime(Carbon::now());
        $to_time = strtotime($date_to);
        return round((($to_time - $from_time) / 60), 1) - $time;
    }


    /**
     * get ratio currency
     */
    public static function changeCurrency($detailSetting, $currency_from, $currecy_to)
    {
        //1 usd = $usd_to_sgd * 1 sgd
        //1 usd = $usd_to_inr * 1 inr
        // $usd_to_sgd * sgd = $usd_to_inr * inr
        if($currency_from == 'usd' && $currecy_to == 'sgd'){
            //case 1 từ usd sang sgd
            return $detailSetting->to_sgd;
        }
        if($currency_from == 'usd' && $currecy_to == 'inr'){
            //case 2 từ usd sang inr
            return $detailSetting->to_inr;
        }
        if($currency_from == 'sgd' && $currecy_to == 'usd'){
            //case 2 từ usd sang inr
            return $detailSetting->sgd_to_usd;
        }
        if($currency_from == 'sgd' && $currecy_to == 'inr'){
            //case 2 từ usd sang inr
            return $detailSetting->sgd_to_inr;
        }
        if($currency_from == 'inr' && $currecy_to == 'usd'){
            //case 2 từ usd sang inr
            return $detailSetting->inr_to_usd;
        }
        if($currency_from == 'inr' && $currecy_to == 'sgd'){
            //case 2 từ usd sang inr
            return $detailSetting->inr_to_sgd;
        }
        return null;
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [km]
     * @return float Distance between points in [km] (same as earthRadius)
     */
    public static function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $earthRadius / 1000, 1) ;
    }

    public static function checkValueVisaType($val)
    {
        if($val == -1) return null;
        return $val;
    }

    /**
     * push notification
     * @author lamnt
     * @date 2020 07 07
     */
    public static function pushNotifyToUsers($userSenderId, $users, $title, $message, $type, $source, $sourceTo, $screen, $params, $data = null)
    {
        $dataOrigin = [
            'screen' => $screen,
            'force' => false,
            'type' => '',
            'params' => $params,
            'status' => 0,
        ];
        if(!empty($data)){
            $dataOrigin = $data;
        }
        $options = [
            'sender_id' => $userSenderId, //Expected: id of sender push
            'user_id' =>   $users, //push recipient id
            'data' => $dataOrigin,
            'title' => $title,
            'message' => $message,
            'reference_id' => $params,
            'type' => $type,
            'source' => $source,
            'source_to' => $sourceTo,
            'screen' => $screen,
        ];
        // dispatch_now(new SavePushNotification($options));
         dispatch(new SavePushNotification($options));
    }

    /**
     * Push notify chat
     *@author anhqt
     * @return void
     */
    public static function pushNotifyChat($userSenderId, $userID, $title, $message, $screen)
    {
        $options = [
            'sender_id' => $userSenderId,
            'user_id' =>   $userID,
            'title' => $title,
            'message' => $message,
            'data' => [
                'screen' => $screen,
                'type'=> 5
            ],
            'type'=> 5,
        ];
        dispatch(new SendPushChat($options));
    }

    public static function clearXSS($string)
    {
        $string = nl2br($string);
        $string = trim(strip_tags($string));
        $string = self::removeScripts($string);

        return $string;
    }
    public static function removeScripts($str)
    {
        $regex =
            '/(<link[^>]+rel="[^"]*stylesheet"[^>]*>)|'.
            '<script[^>]*>.*?<\/script>|'.
            '<style[^>]*>.*?<\/style>|'.
            '<!--.*?-->/is';

        return preg_replace($regex, '', $str);
    }

    public static function clearXssInput($input)
    {
        $data = array_map(function ($value) {
            return self::clearXSS($value);
        }, $input);

        return $data;
    }
    public static function ccMasking($number, $maskingCharacter = '*') {
        return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
    }
    public static function phoneStartsWith($str, $prefix, $pos = 0, $encoding = null)
    {
        if (is_null($encoding)) {
            $encoding = mb_internal_encoding();
        }
        return mb_substr($str, $pos, mb_strlen($prefix, $encoding), $encoding) === $prefix;
    }

    public static function replacePhoneMultiCountries($phone)
    {
        if(empty($phone)){
            return null;
        }
        $phone = explode(' ', $phone);
        if  (self::phoneStartsWith($phone[1], '0')) {
            $phone[1] = substr($phone[1], 1);
        }
        return implode(' ', $phone);
    }

    public static function replacePhone($phone)
    {
        if(empty($phone)){
            return $phone;
        }
        if  (!self::phoneStartsWith($phone, '+84') && !self::phoneStartsWith($phone, '84') && !self::phoneStartsWith($phone, '0')) {
            $phone = '0'.$phone;
            // dd($phone);
        }
        if ($phone == '') {
            return null;
        }
        $search = array('(84)', '(+84)', '+84', ' ', '-');
        $replace = array('0', '0', '0', '', '');
        $phone = str_replace($search, $replace, Ultilities::clearXSS($phone));
        $rest = substr($phone, 0,2);
        if($rest == '84'){
            $rest_phone = substr($phone ,2);
            $phone  = '0'.$rest_phone;
        }
        return $phone;
    }

    /**
     * Format phone number add +84
     *
     * @author anhqt
     * @return void
     */
    public static function formatPhone($phone)
    {
        $phone = str_replace(' ', '', $phone);
        if(str_contains($phone, '+')) {
            return $phone;
        } else {
            return '+' . $phone;
        }
    }


    /**
     * extract phone number + country code
     *
     * @author anhqt
     * @return void
     */
    public static function extractPhone($phone)
    {
        $arrPhone = explode(" ", $phone);
        $countryCode = array_shift($arrPhone);
        $phone = implode("", $arrPhone);
        return [$countryCode, $phone];
    }

    /**
     * Concat phone with country code
     *
     * @author anhqt
     * @param [type] $countryCode
     * @return phone
     */
    public static function concatPhoneCountryCode($phone, $countryCode)
    {
        if(empty($phone)){
            return $phone;
        }

        return $countryCode . ' ' . $phone;
    }

    public static function uploadFile($file , $path = null)
    {
        $publicPath = public_path('uploads');
        if(!empty($path)){
            $publicPath = public_path($path);
        }
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0775, true, true);
        }
        $name = time().$file->getClientOriginalName();

        $name = preg_replace('/\s+/', '', $name);
        $file->move($publicPath, $name);
        if(!empty($path)){
            return $path.'/'.$name;
        }
        return  '/uploads/' .$name;
    }

    //full url image, avatar...
    public static function replaceUrlImage($val, $type = 0)
    {
        $image = '';
        if (!empty($val)) {
            if (!filter_var($val, FILTER_VALIDATE_URL)) {
                $image = url($val);
            } else {
                $image = $val;
            }
        }
        return $image;
    }

    public static function formatDistance($val)
    {
        if($val > 0){
            $data = explode('.', $val);
            if($data[1] === '00'){
                return $data[0];
            }
            return $val;
        }
        return "0";
    }

    public static function logException($ex)
    {
        \Log::error("[ERROR]---------------");
        \Log::error("Message: {$ex->getMessage()}");
        \Log::error("File: {$ex->getFile()}");
        \Log::error("Line: {$ex->getLine()}");
        \Log::error($ex->getTraceAsString());

        \Log::error("[ERROR]---------------");
        return $ex->getMessage();
    }

    public static function getTypeOfExtension($string = null)
    {
        if (empty($string)) {
            return 0;
        }
        $imageExtensions = ['jpeg','jpg','png','gif','heic'];
        $videoExtensions = ['mov','mp4'];

        $ex = pathinfo($string, PATHINFO_EXTENSION);
        $type = 0;
        if (in_array($ex, $imageExtensions)) {
            $type = 1;
        }
        if (in_array($ex, $videoExtensions)) {
            $type = 2;
        }
        return $type;
    }

    /**
     * Send verify phone code using Twilio
     *
     * @author anhqt
     * @return void
     */
    public static function sendVerifyPhoneCode($phoneUser, $message)
    {
        //ngày mai xóa
        if(substr($phoneUser, 0,1) != '+'){
            $phoneUser = '+'.$phoneUser;
        }
        //end

        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $client = new Client($account_sid, $auth_token);

        try {
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                $phoneUser,
                [
                    'from' => config("constants.twilio_number"),
                    'body' => $message
                ]
            );
            return null;

        } catch(RestException $ex) {
            $data = explode('] ', $ex->getMessage());
            $message = $data[1];
            $data =  explode(' ', $data[0]);
            $statusCode = $data[1];
            $dataRes = [
                'statusCode'=> $statusCode,
                'message'=> $message,
            ];
            return $dataRes;
        }
    }

    /**
     * create room
     * @param int type = 2 => video call
     * @param int type = 1 => audio call
     */
    public static function createRoomCall($type, $record = false)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $client = new Client($account_sid, $auth_token);
        $roomName = 'room_'.rand(0,10000000);
        $exists = $client->video->rooms->read([ 'uniqueName' => $roomName]);
        if (empty($exists)) {
            $data = [
                'uniqueName' => $roomName,
                // 'type' => 'peer-to-peer',
                'type' => 'group', // check nếu type pear for pear lỗi thì dùng group
                'recordParticipantsOnConnect' => $record
            ];
            if($type == 1){
                $data['audioOnly'] = true;
            }
            $client->video->rooms->create($data);
            return [
                'roomName' => $roomName
            ];
        }
        return [
            'roomName' => $exists[0]->uniqueName
        ];
    }

    public static function joinRoom($user_name, $room_name)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $api_key = env('TWILIO_API_KEY');
        $api_secret = env('TWILIO_API_SECRET');

        $token = new AccessToken($account_sid, $api_key, $api_secret, 3600, $user_name);
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($room_name);
        $token->addGrant($videoGrant);
        return $token->toJWT();
    }

    public static function completeVideo($name)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $client = new Client($account_sid, $auth_token);
        try{
            return $client->video->v1
            ->rooms($name)->update("completed");

        }catch(Exception $e){
            return $client->video->rooms
            ->read([
                "status" => "completed",
                "uniqueName" => $name
            ])[0];
        }
    }

    public static function getRecordRoom($name)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $client = new Client($account_sid, $auth_token);
        $roomDetail = $client->video->rooms
        ->read([
            "status" => "completed",
            "uniqueName" => $name
        ]);
        if(empty($roomDetail)){
            return 3;
        }
        $roomDetail = $roomDetail[0];

        $recordLink = $roomDetail->links['recordings'];
        $recordLink = self::callAPI($recordLink);
        if(empty($recordLink->recordings)){
            return 2;
        }
        $media = $recordLink->recordings[0]['links'];
        if(empty($media)){
            return 1;
        }
        return $media['media'];
    }

    public static function callAPI($url)
    {
        $client = new \GuzzleHttp\Client();
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $header = [];
        try {
            $response = $client->get($url, [
                'headers' => $header,
                'auth'    =>[$account_sid, $auth_token]
            ]);
        } catch (\Exception $ex) {
            $ex->getMessage();
            $data = [
                "recordings"=>[
                    [
                        "links"=>null
                    ]
                ]
            ];
            return (object) $data;
        }

        $results = null;
        if (
            $response->getStatusCode() == Response::HTTP_OK || $response->getStatusCode() == Response::HTTP_CREATED ||
            $response->getStatusCode() == Response::HTTP_ACCEPTED || $response->getStatusCode() == Response::HTTP_NO_CONTENT
        ) {
            $results = $response->getBody()->getContents();
            $results = json_decode($results, true);
        }
        return (object)$results;
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
           return $bytes = number_format($bytes / 1073741824, 2);    //GB
        } elseif ($bytes >= 1048576) {
           return $bytes = number_format($bytes / 1048576, 2); // MB
        } elseif ($bytes >= 1024) {
           return $bytes = number_format($bytes / 1024, 2); // KB
        } else {
            return $bytes;
        }
    }

    /**
     * Initial Braintree Gateway
     *
     * @author anhqt
     * @return object
     */
    public static function constructBraintreeGateway()
    {
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        return $gateway;
    }

}
