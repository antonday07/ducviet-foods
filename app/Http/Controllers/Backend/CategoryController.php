<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index() {
        return view('backend.contents.category.index');
    }

    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $categories = ProductCategory::all();
            return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('name', function($item){
                return $item->name;
            })
            ->addColumn('description', function($item){
                return $item->description;
            })
            ->addColumn('action', function($item){
                return view('backend.contents.elements.custom-action', [
                    'routeEdit' => route('category.edit', [$item->id]),
                    'routeDelete' => route('category.delete', [$item->id]),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function create() {
        return view('backend.contents.category.create');
    }
    public function store(CategoryRequest $request) {
        $data = $request->all();
        $new_category = ProductCategory::create($data);

        if ($new_category) {
            flasher(__('web.action_success', ['action' => 'Thêm danh mục']), 'success');
            return redirect()->route('category.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Thêm danh mục']), 'error');
            return 'Error!!';
        }
    }
    public function edit($id) {
        $category = ProductCategory::find($id);
        return view('backend.contents.category.edit', compact('category'));
    }
    public function update($id, CategoryRequest $request) {
        $data = $request->all();
        unset($data['_token']);
        $category = ProductCategory::where('id', $id)->update($data);

        if ($category) {
            flasher(__('web.action_success', ['action' => 'Cập nhập danh mục']), 'success');
            return redirect()->route('category.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập danh mục']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $category = ProductCategory::findOrFail($id);
        $status = $category->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa danh mục thành công!";
        } else {
            $success = false;
            $message = "Xóa danh mục thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
