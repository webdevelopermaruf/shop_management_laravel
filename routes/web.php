<?php

use App\Http\Controllers\AdminLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReturnOrderController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::get('/auth/login', [AdminLogController::class, 'viewLogin'])->middleware("outer");
Route::post('/auth/authenticate', [AdminLogController::class, 'Login'])->middleware("outer");

Route::middleware("login")->group(function () {
Route::get('/', [HomeController::class, 'index']);
Route::get('/updated', [HomeController::class, 'updated']);
Route::get('/auth/logout', [AdminLogController::class, 'LogOut']);

Route::get('/profile',[HomeController::class,'profile']);
Route::get('/app/settings',[HomeController::class,'settings']);


Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/edit/{id}', [CategoryController::class, 'getcategory']);
Route::put('/category/update/{id}', [CategoryController::class, 'updatecategory']);
Route::delete('/category/delete/{id}', [CategoryController::class, 'delcategory']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/recall',[ProductController::class,'recall']); // api
Route::get('/product/edit/{id}', [ProductController::class, 'getproduct']);
Route::put('/product/update/{id}', [ProductController::class, 'updateproduct']);
Route::delete('/product/delete/{id}', [ProductController::class, 'delproduct']);
Route::get('/view/existing/product/{id}',[ProductController::class, 'viewProduct']);
Route::post('/view/existing/product/barcode',[ProductController::class, 'viewProductBarcode']);
Route::post('/add/existing/product/barcode',[ProductController::class, 'incrementProduct']);
Route::get('/productlist/{code}',[OrderController::class, 'PerProductInvoices']);


//customer section
Route::get('/customer',[CustomerController::class,'index']);
Route::get('/customer/recall',[CustomerController::class,'recall']); // api
Route::get('/customer/edit/{id}', [CustomerController::class, 'getcustomer']); // api
Route::put('/customer/update/{id}', [CustomerController::class, 'updatecustomer']); //api
Route::delete('/customer/delete/{id}', [CustomerController::class, 'delcustomer']); //api

//order & cart section
Route::get('/quick-order',[OrderController::class,'index']); // quick order page
Route::get('/recall/order',[OrderController::class,'recall']); // recall quick order page
Route::get('/recall/order/{datetimes}',[OrderController::class,'recallwithdatetimes']); // recall quick order page
Route::get('/carts', [CartController::class , 'index']); // carts indexed table
Route::post('/barcode/get',[ProductController::class,'searchProduct']); // barcode get searching
Route::post('/barcode/put', [CartController::class, 'addcartbybarcode']); // 
Route::post('/add/to/cart', [CartController::class, 'addtocart']); // cart item by clicking
Route::get('/update/qty/cart/{id}/{qty}', [CartController::class, 'updateCartItem']); // update cart qty
Route::get('/delete/qty/cart/{id}', [CartController::class, 'deleteCartItem']); // update cart qty
Route::get('/deleteall/to/cart', [CartController::class, 'clearallcart']); // delete all carts
Route::get('/barcode/put/discount/{id}/{dis}', [CartController::class, 'updateCartDiscount']); //  update discount 
Route::post('order/addto/invoice', [CartController::class, 'InvoiceInsert']); //  update discount 
//return order section 
Route::get('/return-order',[ReturnOrderController::class, 'index']);
Route::get('/return-order/select/products/{id}',[ReturnOrderController::class, 'singleItemsSelect']);
Route::put('/quick/return-order/action/return/product/exchange',[ReturnOrderController::class,'withExchangeProduct']);
Route::put('/quick-order/select/orders/items',[OrderController::class , 'selectOrderReturn']);
Route::get('/quick-order/select/products/{id}',[OrderController::class , 'selectProductReturn']);
Route::put('/quick/return-order/action/return/price/',[ReturnOrderController::class,'withReturnMoney']);

//expenses section 
Route::get('/expenses',[ExpensesController::class,'index']);
Route::get('/expenses/recall',[ExpensesController::class,'recall']);

//inventory 
Route::get('/outofstock',[ProductController::class,'outofstock']); // view inventory page

//invoice section
Route::get('/inventory',[ProductController::class,'inventory'])->middleware('adminonly'); // view inventory page
Route::get('/get/invoice/{id}', [InvoiceController::class, 'show']);
Route::get('/get/sell/{id}', [InvoiceController::class, 'getSell']);

// import section
Route::get('app/import/',[ImportController::class,'productView']);
Route::post('app/import/customer',[ImportController::class,'importCustomer']);
Route::post('app/import/product',[ImportController::class,'importProduct']);
Route::post('app/import/order',[ImportController::class,'importOrder']);

//export section
Route::get('app/export/inventory/product',[ExportController::class, 'inventoryProduct'])->middleware('adminonly');
Route::get('app/export/stockout/product',[ExportController::class, 'stockOutProduct'])->middleware('adminonly');

//print section
Route::get('/generate/invoice/{id}', [OrderController::class, 'printInvoice']); 
Route::get('/generate/barcode/{code}/{qty}',[ProductController::class, 'generateBarcode']);
Route::get('/report',[ReportController::class, 'profitReport']); // view report
Route::get('/generate/profit/{first}/{last}',[ReportController::class, 'generateReport'])->middleware('adminonly');
Route::get('/generate/monthly/report/{month}',[ReportController::class, 'monthlyReport'])->middleware('adminonly');
Route::get('/generate/order/report/{first}/{last}',[ReportController::class, 'viewOrdersReport']);
Route::view('/not/permitted','errors.notPermitted');

//deploy purpose
Route::get('/app/storage/link', function(){
    Artisan::call('storage:link');
});
Route::get('/app/clear/all',function()
{
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    return 'Happy Hacking!';
});

});