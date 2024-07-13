<?php

namespace App\Http\Controllers;

use App\Events\Order;
use App\Models\CustomerModel;
use App\Models\InvoiceModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ReturnOrderModel;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $site = SiteSettings::where('site_no', 1)->first();
        $favourite = ProductModel::where('product_qty', '>', '0')->take(6)->get();
        $orders = OrderModel::orderBy('orders_id', 'desc')
            ->whereDate('orders_creation', '>=', date('Y-m-d', strtotime("-60 days")))
            ->get();
        return view('Pages.order', ['customers' => CustomerModel::all(), 'favourites' => $favourite, 'orders' => $orders, 'site' => $site]);
    }
    public function recall()
    {
        return OrderModel::latest('orders_creation')->whereDate('orders_creation', '>=', date('Y-m-d', strtotime("-60 days")))
            ->get();
    }
    public function printInvoice($id)
    {
        $site = SiteSettings::where('site_no', 1)->first();
        $orders = OrderModel::where('orders_id', $id)->first();
        $items = InvoiceModel::where('invoice_order_no', $id)->get();
        return view('Print.invoice', ['site' => $site, 'orders' => $orders, 'items' => $items]);
    }
    public function recallwithdatetimes($datetimes)
    {
        return OrderModel::latest('orders_creation')->whereDate('orders_creation', '>=', date('Y-m-d', strtotime("-" . $datetimes . "days")))
            ->get();
    }
    public function selectOrderReturn(Request $req)
    {
        if($req->invoice != null){
            return OrderModel::where('orders_id',$req->invoice)->get();
        }

        if($req->phone != null && $req->orderDate != null){
            return OrderModel::whereDate('orders_creation', $req->orderDate)->where('orders_holder_phone',$req->phone)->get();
        }

        if ($req->phone != null) {
            return OrderModel::where('orders_holder_phone', $req->phone)->get();
        }
        if ($req->orderDate != null) {
            return OrderModel::whereDate('orders_creation', $req->orderDate)->get();
        }
        

      
    }
    public function selectProductReturn($id)
    {
        $check = ReturnOrderModel::where('pre_order_no',$id)->count();
        if($check == 0){
            return InvoiceModel::where('invoice_order_no',$id)->get();
        }else{
            return 'returned';
        }

    }
    public function PerProductInvoices($code){
        return InvoiceModel::where('invoice_barcode', $code)->get();
    }
}
