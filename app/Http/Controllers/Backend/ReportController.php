<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function indexIncome()
    {
        return view('backend.contents.report.index_income');
    }

    public function indexProduct()
    {
        return view('backend.contents.report.index_product');
    }

    public function indexOrder()
    {
        return view('backend.contents.report.index_order');
    }

    public function indexWarehouse()
    {
        return view('backend.contents.report.index_warehouse');
    }

    public function getDatatableIncome(Request $request, Product $product)
    {
        if($request->ajax()){
            
            $products = $product->getListProduct($request);
        
            return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($item){
                return '<a href="' . $item->image . '">
                        <img src="' . $item->image . '" class="img-fluid"/>
                    </a>';
             
            })               
            ->addColumn('name', function($item){
                return $item->name;                                
             })  
            ->addColumn('unit', function($item){
                return $item->unit->name;
            })
            ->addColumn('amount_entry', function($item){
                return  number_format($item->billProductsDetail->sum('price'), 0,'', '.') . ' đ';
            })            
            ->addColumn('amount_sell', function($item){
                return  number_format($item->billDetails->sum('price'), 0,'', '.') . ' đ';
            })
            ->addColumn('total', function($item){
                $sell = $item->billDetails->sum('price');
                $entry = $item->billProductsDetail->sum('price');
                return number_format($sell - $entry, 0,'', '.') . ' đ';
             
            })
            ->rawColumns(['thumbnail'])
            ->make(true);
        }
    }


    public function getDatatableProduct(Request $request, Product $product)
    {
        if($request->ajax()){
            
            $products = $product->getListProduct($request);
        
            return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($item){
                return '<a href="' . $item->image . '">
                        <img src="' . $item->image . '" class="img-fluid"/>
                    </a>';
             
            })               
            ->addColumn('name', function($item){
                return $item->name;                                
             })  
            ->addColumn('unit', function($item){
                return $item->unit->name;
            })
            ->addColumn('amount_entry', function($item) use ($request) {
                if(!empty($request->month) && !empty($request->year)) {
            
                    return  $item->billProductsDetail()->whereMonth('created_at', $request->month)
                                                    ->whereYear('created_at', $request->year)->get()->sum('amount');
                }  
                return  $item->billProductsDetail->sum('amount');
                
            })            
            ->addColumn('amount_sell', function($item) use ($request){

                if(!empty($request->month) && !empty($request->year)) {
            
                    return  $item->billDetails()->whereMonth('created_at', $request->month)
                                                    ->whereYear('created_at', $request->year)->get()->sum('amount');
                }  
                return  $item->billDetails->sum('amount');

            })
            ->addColumn('total', function($item){
                $sell = $item->billDetails->sum('amount');
                $entry = $item->billProductsDetail->sum('amount');
                return $entry - $sell;
            })
            ->rawColumns(['thumbnail'])
            ->make(true);
        }
    }

    public function getDatatableOrder(Request $request, Product $product)
    {
        if($request->ajax()){
            
            $products = $product->getListProduct($request);
        
            return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($item){
                return '<a href="' . $item->image . '">
                        <img src="' . $item->image . '" class="img-fluid"/>
                    </a>';
             
            })               
            ->addColumn('name', function($item){
                return $item->name;                                
             })  
            ->addColumn('unit', function($item){
                return $item->unit->name;
            })
            ->addColumn('amount_entry', function($item){
                return  number_format($item->billProductsDetail->sum('price'), 0,'', '.') . ' đ';
            })            
            ->addColumn('amount_sell', function($item){
                return  number_format($item->billDetails->sum('price'), 0,'', '.') . ' đ';
            })
            ->addColumn('total', function($item){
                $sell = $item->billDetails->sum('price');
                $entry = $item->billProductsDetail->sum('price');
                return number_format($sell - $entry, 0,'', '.') . ' đ';
             
            })
            ->rawColumns(['thumbnail'])
            ->make(true);
        }
    }

}
