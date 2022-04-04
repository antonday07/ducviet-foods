<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ShippingController extends Controller
{
    public function index()
    {
        $employees = Shipping::paginate(10);
        return view('backend.contents.shipping.index', compact('employees'));
    }

    public function getDatatable(Request $request, Shipping $shipping)
    {
        if($request->ajax()){
            $shippings = Shipping::all();
            return DataTables::of($shippings)
            ->addIndexColumn()
            ->addColumn('name', function($item){
                return $item->name;
            })
            ->addColumn('email', function($item){
                return $item->email;
            })
            ->addColumn('address', function($item){
                return $item->address;
            })        
            ->addColumn('action', function($item){
                return view('backend.contents.elements.custom-action', [
                    'routeEdit' => route('shipping.edit', [$item->id]),
                    'routeDelete' => route('shipping.delete', [$item->id]),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function createToken(Request $request)
    {
        $shipping = Shipping::find($request->id);
   
        $token = $shipping->createToken('token-shipping');

        Shipping::where('id', $request->id)->update([
            'token' => $token->plainTextToken
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Tạo token thành công',
            'token' => $token->plainTextToken
        ]);

    }

    public function create()
    {
        return view('backend.contents.shipping.create');
    }
    public function store(ShippingRequest $request)
    {
        $data = $request->all();
      
        
        unset($data['_token']);
        $data['password'] = Hash::make($request->password);
        $newShipping = Shipping::create($data);
        if ($newShipping) {
            flasher(__('web.action_success', ['action' => 'Thêm nhà vận chuyển']), 'success');
            return redirect()->route('shipping.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Thêm nhà vận chuyển']), 'error');
            return 'Error!!';
        }
    }

    public function edit($id) {
        $shipping = Shipping::find($id);
        return view('backend.contents.shipping.edit', compact('shipping'));
    }
    public function update(ShippingRequest $request, $id){
        $data = $request->all();
        unset($data['_token']);
        $employee = Shipping::where('id', $id)->update($data);
        if ($employee) {
            flasher(__('web.action_success', ['action' => 'Cập nhập nhà vận chuyển']), 'success');
            return redirect()->route('shipping.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập nhà vận chuyển']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $employee = Shipping::findOrFail($id);
        $status = $employee->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa nhà vận chuyển thành công!";
        } else {
            $success = false;
            $message = "Xóa nhà vận chuyển thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
