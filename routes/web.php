<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Events\notification;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Frontend\HomeController@index')->name('trangchu');
Route::get('/search', 'Frontend\HomeController@search')->name('search');


Route::get('/shopping', 'Frontend\ProductController@product')->name('product');
Route::get('/about', 'Frontend\AboutController@about')->name('about');
Route::get('/product_detail', 'HomeController@productDetail')->name('productDetail');
Route::get('/login', 'HomeController@authenticate')->name('authenticate');


Route::get('/product', 'Backend\ProductController@product');
Route::get('/detail/{id}', 'Frontend\ProductController@detail')->name('detail');

Route::get('/render-product', 'Frontend\ProductController@renderProductByCategory')->name('renderProduct');
Route::get('/render-product-search', 'Frontend\ProductController@renderProductBySearch')->name('renderProductBySearch');

Route::get('/search-product', 'Frontend\ProductController@searchProduct')->name('searchProduct');
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sendemail', 'SendEmailController@index')->name('sendemail');
Route::post('/sendemail/send', 'SendEmailController@send');


Route::group(['prefix' => 'admin'], function () {
 
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('login.admin');
    Route::post('login', 'Admin\LoginController@login');
    Route::post('logout', 'Admin\LoginController@logout')->name('logout.admin');
});
Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/admin', 'Backend\DashboardController@index')->name('admin.index');
   // Route::get('/dashboard', 'Backend\DashboardController@index')->name('admin.index');
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'customer'], function () {

            Route::get('index', 'Backend\CustomerController@index')->name('customer.index');
            Route::get('datatable', 'Backend\CustomerController@getDatatable')->name('customer.datatable');
            Route::get('create', 'Backend\CustomerController@create')->name('customer.create');
            Route::post('create', 'Backend\CustomerController@store')->name('customer.store');

            Route::get('edit/{id}', 'Backend\CustomerController@edit')->name('customer.edit');
            Route::post('edit/{id}', 'Backend\CustomerController@update')->name('customer.update');
            Route::delete('delete/{id}', 'Backend\CustomerController@delete')->name('customer.delete');

        });
        Route::group(['prefix' => 'promotion'], function () {
            Route::get('index', 'Backend\PromotionController@index')->name('promotion.index');
            Route::get('datatable', 'Backend\PromotionController@getDatatable')->name('promotion.datatable');
            Route::get('create', 'Backend\PromotionController@create')->name('promotion.create');
            Route::post('create', 'Backend\PromotionController@store')->name('promotion.store');

            Route::get('edit/{id}', 'Backend\PromotionController@edit')->name('promotion.edit');
            Route::post('edit/{id}', 'Backend\PromotionController@update')->name('promotion.update');
            Route::delete('delete/{id}', 'Backend\PromotionController@delete')->name('promotion.delete');
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('index', 'Backend\OrderController@index')->name('order.index');
            Route::get('datatable', 'Backend\OrderController@getDatatable')->name('order.datatable');
            Route::get('detail/{id}', 'Backend\OrderController@detail')->name('order.detail');
            Route::get('edit/{id}', 'Backend\OrderController@edit')->name('order.edit');
            Route::post('changeStatus', 'Backend\OrderController@changeStatus')->name('order.change');
            Route::post('cancelOrder', 'Backend\OrderController@cancelOrder')->name('order.cancel');
        });

        Route::group(['prefix' => 'warehouse'], function () {
            Route::get('index', 'Backend\WarehouseController@index')->name('warehouse.index');
            Route::get('datatable', 'Backend\WarehouseController@getDatatable')->name('warehouse.datatable');
          
        });

        Route::group(['prefix' => 'employee'], function () {
            Route::get('index', 'Backend\EmployeeController@index')->name('employee.index');
            Route::get('datatable', 'Backend\EmployeeController@getDatatable')->name('employee.datatable');
            Route::get('create', 'Backend\EmployeeController@create')->name('employee.create');
            Route::post('create', 'Backend\EmployeeController@store')->name('employee.store');

            Route::get('edit/{id}', 'Backend\EmployeeController@edit')->name('employee.edit');
            Route::post('edit/{id}', 'Backend\EmployeeController@update')->name('employee.update');
            Route::delete('delete/{id}', 'Backend\EmployeeController@delete')->name('employee.delete');
        });
        Route::group(['prefix' => 'product'], function () {
            Route::get('index', 'Backend\ProductController@index')->name('product.index');
            Route::get('datatable', 'Backend\ProductController@getDatatable')->name('product.datatable');
            Route::get('create', 'Backend\ProductController@create')->name('product.create');
            Route::post('create', 'Backend\ProductController@store')->name('product.store');

            Route::get('edit/{id}', 'Backend\ProductController@edit')->name('product.edit');
            Route::post('edit/{id}', 'Backend\ProductController@update')->name('product.update');
            Route::delete('delete/{id}', 'Backend\ProductController@delete')->name('product.delete');
        });
        Route::group(['prefix' => 'category'], function () {
            Route::get('index', 'Backend\CategoryController@index')->name('category.index');
            Route::get('datatable', 'Backend\CategoryController@getDatatable')->name('category.datatable');
            Route::get('create', 'Backend\CategoryController@create')->name('category.create');
            Route::post('create', 'Backend\CategoryController@store')->name('category.store');

            Route::get('edit/{id}', 'Backend\CategoryController@edit')->name('category.edit');
            Route::post('edit/{id}', 'Backend\CategoryController@update')->name('category.update');
            Route::delete('delete/{id}', 'Backend\CategoryController@delete')->name('category.delete');
        });

        Route::group(['prefix' => 'unit'], function () {
            Route::get('index', 'Backend\UnitController@index')->name('unit.index');
            Route::get('datatable', 'Backend\UnitController@getDatatable')->name('unit.datatable');
            Route::get('create', 'Backend\UnitController@create')->name('unit.create');
            Route::post('create', 'Backend\UnitController@store')->name('unit.store');

            Route::get('edit/{id}', 'Backend\UnitController@edit')->name('unit.edit');
            Route::post('edit/{id}', 'Backend\UnitController@update')->name('unit.update');
            Route::delete('delete/{id}', 'Backend\UnitController@delete')->name('unit.delete');
        });

        
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('index', 'Backend\SupplierController@index')->name('supplier.index');
            Route::get('datatable', 'Backend\SupplierController@getDatatable')->name('supplier.datatable');
            Route::get('create', 'Backend\SupplierController@create')->name('supplier.create');
            Route::post('create', 'Backend\SupplierController@store')->name('supplier.store');

            Route::get('edit/{id}', 'Backend\SupplierController@edit')->name('supplier.edit');
            Route::post('edit/{id}', 'Backend\SupplierController@update')->name('supplier.update');
            Route::delete('delete/{id}', 'Backend\SupplierController@delete')->name('supplier.delete');
        });

        Route::group(['prefix' => 'bill-import'], function () {
            Route::get('index', 'Backend\BillImportController@index')->name('bill.import.index');
            Route::get('datatable', 'Backend\BillImportController@getDatatable')->name('bill.import.datatable');
            Route::get('/product/index', 'Backend\BillImportController@productIndex')->name('bill.import.product.index');
            Route::get('product/datatable', 'Backend\BillImportController@productDatatable')->name('bill.import.product.datatable');
            Route::get('create', 'Backend\BillImportController@create')->name('bill.import.create');
            Route::post('create', 'Backend\BillImportController@store')->name('bill.import.store');

            Route::get('edit/{id}', 'Backend\BillImportController@edit')->name('bill.import.edit');
            Route::post('edit/{id}', 'Backend\BillImportController@update')->name('bill.import.update');
            Route::delete('delete/{id}', 'Backend\BillImportController@delete')->name('bill.import.delete');
        });
    });
});
Route::get('cart', 'Frontend\CartController@index')->name('cart');
Route::post('delete', 'Frontend\CartController@removeCart')->name('removefromcart');
Route::post('changeqty', 'Frontend\CartController@updateCart')->name('changeqty');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'Frontend\CheckOutController@CheckOut')->name('checkout');
    Route::get('/finishshopping', 'Frontend\CheckOutController@FinishShopping')->name('finishshopping');
});
Route::post('add', 'Frontend\CartController@addCart')->name('addtocart');


Route::group(['middleware' => ['auth'], 'prefix' => 'profile'], function () {
    Route::get('/', 'Frontend\ProfileController@index')->name('profile');
    Route::post('/update/{id}', 'Frontend\ProfileController@update')->name('updateProfile');
});
