<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Libraries\Ultilities;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Supplier;
use App\Models\Unit;
use Flasher\Laravel\Facade\Flasher;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('backend.contents.product.index');
    }

    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $products = Product::all();
            return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($product){
                return '<a href="' . $product->image . '">
                        <img src="' . $product->image . '" class="img-fluid"/>
                    </a>';
             
            })
            ->addColumn('name', function($product){
                return $product->name;
            })
            ->addColumn('entry_price', function($product){
                return  number_format($product->entry_price, 0,'', '.') . ' đ';
            })
            ->addColumn('retail_price', function($product){
                return  number_format($product->retail_price, 0,'', '.') . ' đ';

            })
            ->addColumn('status', function($product){
                $badgeName = [
                    1 => 'badge-info',
                    2 => 'badge-secondary',
                    3 => 'badge-primary'
                ];
                return '<span class="badge ' . $badgeName[$product->status] . ' ">' . config('constants.status_product_label')[$product->status] . '</span>';
            })
            ->addColumn('action', function($product){
                return view('backend.contents.product.custom-action', [
                    'product' => $product
                ]);
            })
            ->rawColumns(['thumbnail', 'action', 'status'])
            ->make(true);
        }
    }
    public function create()
    {
        return view('backend.contents.product.create', [
            'categories' => ProductCategory::select('id', 'name')->get(),
            'promotions' => Promotion::select('id', 'name')->get(),
            'units' =>  Unit::select('id', 'name')->get(),
            'suppliers' => Supplier::select('id', 'name')->get()
        ]);
    }
    public function store(ProductRequest $request)
    {
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            $data['image'] = Ultilities::uploadFile($request->image);
        }
        // return $data;
        $new_product = Product::create($data);
        if ($new_product) {
            flasher(__('web.action_success', ['action' => 'Thêm sản phẩm']), 'success');
            return redirect()->route('product.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Thêm sản phẩm']), 'error');
            return 'Error!!';
        }
    }
    public function edit($id) {
        return view('backend.contents.product.edit', [
            'categories' => ProductCategory::select('id', 'name')->get(),
            'promotions' => Promotion::select('id', 'name')->get(),
            'units' =>  Unit::select('id', 'name')->get(),
            'suppliers' => Supplier::select('id', 'name')->get(),
            'product' => Product::find($id)
        ]);
    }
    public function update(ProductRequest $request, $id){
        $data = $request->all();
        unset($data['_token']);
        $product = Product::where('id', $id)->update($data);
        if ($product) {
            flasher(__('web.action_success', ['action' => 'Cập nhập sản phẩm']), 'success');
            return redirect()->route('product.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập sản phẩm']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $product = Product::findOrFail($id);
        $status = $product->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa sản phẩm thành công!";
        } else {
            $success = false;
            $message = "Xóa sản phẩm thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
