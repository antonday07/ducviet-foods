<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillImportDetail;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {                  
        return view('backend.contents.warehouse.index', [
            'products' => Product::select('id', 'name', 'entry_price')->get(),
        ]);
    }
    
    public function getDatatable(Request $request, Warehouse $bill)
    {
        if($request->ajax()){
            $bills = $bill->getListProductWarehouse($request);
        
            return DataTables::of($bills)
            ->addIndexColumn()
            ->addColumn('product', function($item){
                return $item->product->name;                                
             })  
            ->addColumn('sum_import', function($item){
               return  BillImportDetail::where('product_id', $item->product_id)->count();                                
            })          
            ->addColumn('quantity', function($item){
                return $item->quantity;
            })
            // ->rawColumns(['action', 'status', 'status_payment'])
            ->make(true);
        }
    }
}
