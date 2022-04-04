<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Ultilities;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(User $user) {
        return view('frontend.contents.profile.index', [
            'user' => $user->getDetailById(auth()->user()->id)
        ]);
    }

    public function viewOrder(Request $request, Bill $bill)
    {
        // $order = $bill->findById($request->id);
        // dd($order);
        return view('frontend.contents.profile.order', [
            'order' => $bill->findById($request->id)
        ]);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = Ultilities::uploadFile($request->avatar);        
        }
        unset($data['_token']);
        $status = User::where('id', $id)->update($data);
        if ($status == 1) {
            flasher(__('web.action_success', ['action' => 'Cập nhập thông tin']), 'success');
            return back();
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập thông tin']), 'error');
           return back();
        }
            
    }
}
