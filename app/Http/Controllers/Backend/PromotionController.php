<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    public function index() {
        return view('backend.contents.promotion.index');
    }
    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $promotions = Promotion::all();
            return DataTables::of($promotions)
            ->addIndexColumn()
            ->addColumn('name', function($item){
                return $item->name;
            })
            ->addColumn('description', function($item){
                return $item->description;
            })
            ->addColumn('type', function($item){
                return $item->type;
            })
            ->addColumn('price', function($item){
                return $item->price;
            })
            ->addColumn('date_from', function($item){
                return $item->date_from;
            })
            ->addColumn('date_expiry', function($item){
                return $item->date_expiry;
            })
            ->addColumn('action', function($item){
                return view('backend.contents.elements.custom-action', [
                    'routeEdit' => route('promotion.edit', [$item->id]),
                    'routeDelete' => route('promotion.delete', [$item->id]),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function create() {  
        return view('backend.contents.promotion.create');
    }
    public function store(PromotionRequest $request) {
        $data = $request->all();
        $new_promo = Promotion::create($data);
        if ($new_promo) {
            return redirect()->route('promotion.index');
        } else {
            return 'Error!!';
        }
    }

    public function edit($id) {
        $promotion = Promotion::find($id);
        return view('backend.contents.promotion.edit', compact('promotion'));
    }
    public function update($id, PromotionRequest $request) {
        $data = $request->all();
        unset($data['_token']);
        $promotion = Promotion::where('id', $id)->update($data);

        if ($promotion) {
            flasher(__('web.action_success', ['action' => 'Cập nhập danh mục']), 'success');
            return redirect()->route('promotion.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập danh mục']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $promotion = Promotion::findOrFail($id);
        $status = $promotion->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa khuyến mãi thành công!";
        } else {
            $success = false;
            $message = "Xóa khuyến mãi thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
