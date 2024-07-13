<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ReturnOrderModel;
use App\Models\ReturnProductModel;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class ReturnOrderController extends Controller
{
    function index(){
        $ReturnedOrders = ReturnOrderModel::orderBy('ro_creation','desc')->get();
        $site = SiteSettings::where('site_no', 1)->first();
        return view('Pages.return-order',['returnorders'=> $ReturnedOrders,'site'=>$site]);
    }
    function singleItemsSelect($id){
        return ReturnProductModel::where('rp_order_no',$id)->get();
    }
    function withReturnMoney(Request $req)
    {

        $ReturnedOrders = ReturnOrderModel::insert([
            "ro_cus_name" => $req->cusname,
            "ro_cus_phone" => $req->cusphn,
            "pre_order_no" => $req->pre_order_no,
            "exchange_order_no" => null,
            "ro_qty" => $req->totalQty,
            "ro_money" => $req->totalReturnMoney,
        ]);

        $rp_order_no = ReturnOrderModel::where('pre_order_no', $req->pre_order_no)->value('ro_id');
        foreach ($req->returnProducts as $item) {
            ReturnProductModel::insert([
                'ro_product_name' => $item['name'],
                'ro_product_barcode' => $item['barcode'],
                'return_qty' => $item['returnQty'],
                'pre_order_no' => $req->pre_order_no,
                'rp_order_no' => $rp_order_no,
            ]);

            $product_det = ProductModel::where('product_barcode', $item['barcode'])->first();
            $balance_qty = $product_det['product_qty'];
            $sold_qty = $product_det['product_sold'];

            ProductModel::where('product_barcode', $item['barcode'])->update([
                'product_qty' => $balance_qty + $item['returnQty'],
                'product_sold' => $sold_qty - $item['returnQty'],
            ]);
        }
        return 'done';
    }
    function withExchangeProduct(Request $req)
    {
        $lastOrder = OrderModel::where('orders_id',$req->newOrderId)->first();
        $cusname = $lastOrder['orders_holder'];
        $cusphn = $lastOrder['orders_holder_phone'];

        $ReturnedOrders = ReturnOrderModel::insert([
            "ro_cus_name" => $cusname,
            "ro_cus_phone" => $cusphn,
            "pre_order_no" => $req->pre_order_no,
            "exchange_order_no" => $req->newOrderId,
            "ro_qty" => $req->totalQty,
            "ro_money" => $req->totalReturnMoney,
        ]);

        $rp_order_no = ReturnOrderModel::where('pre_order_no', $req->pre_order_no)->value('ro_id');
        foreach ($req->returnProducts as $item) {
            ReturnProductModel::insert([
                'ro_product_name' => $item['name'],
                'ro_product_barcode' => $item['barcode'],
                'return_qty' => $item['returnQty'],
                'pre_order_no' => $req->pre_order_no,
                'rp_order_no' => $rp_order_no,
            ]);

            $product_det = ProductModel::where('product_barcode', $item['barcode'])->first();
            $balance_qty = $product_det['product_qty'];
            $sold_qty = $product_det['product_sold'];

            ProductModel::where('product_barcode', $item['barcode'])->update([
                'product_qty' => $balance_qty + $item['returnQty'],
                'product_sold' => $sold_qty - $item['returnQty'],
            ]);
        }
        return 'done';
    }
}
