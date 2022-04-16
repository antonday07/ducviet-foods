<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillImport;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
        $products = Product::all();
        $customers = User::all();
       
        $count = DB::table('bills')->count('id');
        $now = Carbon::now()->month; 
        $sell = Bill::with('billDetails')->get()->sum('total_price');
        $entry = BillImport::with('productBills')->get()->sum('total_price');
        $total = $entry - $sell;
        
        return view('backend.contents.dashboard.index', compact('products', 'customers','count', 'now', 'total'));
    }
}
