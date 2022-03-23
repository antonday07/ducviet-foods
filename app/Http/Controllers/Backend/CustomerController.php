<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index() {
        return view('backend.contents.customer.index');
    }

    public function getDatatable(Request $request, User $user)
    {
        if($request->ajax()){
            $employees = $user->findAllCustomer($request);
            return DataTables::of($employees)
            ->addIndexColumn()
            ->addColumn('name', function($item){
                return $item->name;
            })
            ->addColumn('email', function($item){
                return $item->email;
            })
            ->addColumn('avatar', function($item){
                return '<a href="' . $item->avatar . '">
                        <img src="' . $item->avatar . '" class="img-fluid"/>
                    </a>';
             
            })
            ->addColumn('phone', function($item){
                return $item->phone;
            })
            ->addColumn('address', function($item){
                return $item->address;
            })
            // ->addColumn('action', function($item){
            //     return view('backend.contents.elements.custom-action', [
            //         'routeEdit' => route('employee.edit', [$item->id]),
            //         'routeDelete' => route('employee.delete', [$item->id]),
            //     ]);
            // })
            ->rawColumns(['avatar'])
            ->make(true);
        }
    }

    public function create()
    {
        return view('backend.contents.employee.create');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        
        unset($data['_token']);
        $data['role'] = Admin::EMPLOYEE;
        $data['password'] = Hash::make($request->password);
        $new_employee = Admin::create($data);
        if ($new_employee) {
            flasher(__('web.action_success', ['action' => 'Thêm nhân viên']), 'success');
            return redirect()->route('employee.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Thêm nhân viên']), 'error');
            return 'Error!!';
        }
    }

    public function edit($id) {
        $employee = Admin::find($id);
        return view('backend.contents.employee.edit', compact('employee'));
    }
    public function update(EmployeeRequest $request, $id){
        $data = $request->all();
        unset($data['_token']);
        $employee = Admin::where('id', $id)->update($data);
        if ($employee) {
            flasher(__('web.action_success', ['action' => 'Cập nhập nhân viên']), 'success');
            return redirect()->route('employee.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập nhân viên']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $employee = User::findOrFail($id);
        $status = $employee->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa khách hàng thành công!";
        } else {
            $success = false;
            $message = "Xóa khách hàng thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

   
}
