<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index() {
        return view('backend.contents.unit.index');
    }

    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $units = Unit::all();
            return DataTables::of($units)
            ->addIndexColumn()
            ->addColumn('name', function($item){
                return $item->name;
            })
            ->addColumn('description', function($item){
                return $item->description;
            })
            ->addColumn('action', function($item){
                return view('backend.contents.elements.custom-action', [
                    'routeEdit' => route('unit.edit', [$item->id]),
                    'routeDelete' => route('unit.delete', [$item->id]),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function create() {
        return view('backend.contents.unit.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        $data = $request->all();
        $unit = Unit::create($data);

        if ($unit) {
            flasher(__('web.action_success', ['action' => 'Thêm đơn vị']), 'success');
            return redirect()->route('unit.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Thêm đơn vị']), 'error');
            return 'Error!!';
        }
    }
    public function edit($id) {
        $unit = Unit::find($id);
        return view('backend.contents.unit.edit', compact('unit'));
    }
    public function update($id, Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);
        $data = $request->all();
        unset($data['_token']);
        $unit = Unit::where('id', $id)->update($data);

        if ($unit) {
            flasher(__('web.action_success', ['action' => 'Cập nhập đơn vị']), 'success');
            return redirect()->route('unit.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập đơn vị']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $unit = Unit::findOrFail($id);
        $status = $unit->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa đơn vị thành công!";
        } else {
            $success = false;
            $message = "Xóa đơn vị thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
