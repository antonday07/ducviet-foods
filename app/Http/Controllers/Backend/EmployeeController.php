<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Admin::paginate(10);
        return view('backend.contents.employee.index', compact('employees'));
    }

    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $employees = Admin::where('role', Admin::EMPLOYEE)->get();
            return DataTables::of($employees)
            ->addIndexColumn()
            ->addColumn('name', function($item){
                return $item->name;
            })
            ->addColumn('email', function($item){
                return $item->email;
            })
            ->addColumn('phone', function($item){
                return $item->phone;
            })
            ->addColumn('address', function($item){
                return $item->address;
            })
            ->addColumn('role', function($item){
                return '<span class="badge badge-primary">Nhân viên</span>';
            })
            ->addColumn('action', function($item){
                return view('backend.contents.elements.custom-action', [
                    'routeEdit' => route('employee.edit', [$item->id]),
                    'routeDelete' => route('employee.delete', [$item->id]),
                ]);
            })
            ->rawColumns(['action', 'role'])
            ->make(true);
        }
    }

    public function create()
    {
        return view('backend.contents.employee.create');
    }
    public function store(EmployeeRequest $request)
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
        return view('backend.contents.employee.edit');
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
        $employee = Admin::findOrFail($id);
        $status = $employee->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa nhân viên thành công!";
        } else {
            $success = false;
            $message = "Xóa nhân viên thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
