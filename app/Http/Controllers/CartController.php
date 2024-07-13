<?php

namespace App\Http\Controllers;

use App\Events\Order;
use App\Models\CustomerModel;
use App\Models\InvoiceModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function __construct()
    {
        \Cart::session('product');
    }
    public function index()
    {
        $cartItems = \Cart::getContent();
        return $cartItems;
    }

    public function addtocart(Request $req)
    {
        $item = ProductModel::where('product_id', $req->id)->first();
        if($item == null){
            return;
        }

        \Cart::add([
            'id' => $req->id,
            'name' => $item->product_name,
            'price' => $item->product_sell_price,
            'quantity' => $req->orderqty == null ? 1 : $req->orderqty,
            'attributes' => array(
                'stock' => $item->product_qty,
                'factory' => $item->product_purchase_price,
            )
        ]);
        \Cart::update(
            $req->id,
            ['discount' =>0]
        );
        return \Cart::getContent();
    }

    public function addcartbybarcode(Request $req)
    {

        $item = ProductModel::where('product_barcode', $req->barcode)->first();

        if($item->product_qty == 0){
            return 'empty';
        }

        if($item == null){
            return;
        }

        \Cart::add([
            'id' => $item->product_id,
            'name' => $item->product_name,
            'price' => $item->product_sell_price,
            'quantity' => $req->orderqty == null ? 1 : $req->orderqty,
            'attributes' => array(
                'stock' => $item->product_qty,
                'factory' => $item->product_purchase_price,
                )
        ]);
        \Cart::update(
            $item->product_id,
            ['discount' =>0]
        );

        return \Cart::getContent();
    }


    public function clearallcart()
    {
        \Cart::clear();
        return 'done';
    }

    public function updateCartItem($id, $qty)
    {
        \Cart::update(
            $id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $qty
                ],
            ]
        );
        return;
    }

    public function updateCartDiscount($id, $dis)
    {
        \Cart::update(
            $id,
            [
                'discount' =>$dis,
            
            ]
        );
        return 'done';
    }

 
    public function deleteCartItem($id)
    {
        \Cart::remove($id);
        return \Cart::getContent();
    }

    public function InvoiceInsert(Request $req)
    {
        $customer = $req->customer;
        $totalPurchase = 0;
        if($customer != 'guest'){
            $getcustomer = CustomerModel::where('customer_id', $req->customer)->first();
        }

        $invoiceOrder = OrderModel::orderBy('orders_id','desc')->pluck('orders_id')->first()+1;

        foreach (\Cart::getContent() as $item) {
            $productSelected = ProductModel::where('product_id', $item->id)->first();
            $totalPurchase += $productSelected->product_purchase_price * $item->quantity;
            $addsell = InvoiceModel::insert([
                'invoice_order_no'=> $invoiceOrder,
                'invoice_holder'=> $customer=='guest'?'guest': $getcustomer->customer_name,
                'invoice_holder_phone'=> $customer=='guest'?'guest': $getcustomer->customer_phone,
                'invoice_product'=> $item->name,
                'invoice_barcode'=> $productSelected->product_barcode,
                'invoice_factory'=> $productSelected->product_purchase_price * $item->quantity,
                'invoice_sell'=> $item->price * $item->quantity,
                'invoice_discount'=> $item->discount,
                'invoice_paid'=> ($item->price * $item->quantity) - $item->discount,
                'invoice_qty'=> $item->quantity,
            ]);

            $updateProduct = ProductModel::where('product_id',$item->id)->decrement('product_qty', $item->quantity);
        }
        if($totalPurchase == 0){
            \Cart::clear();
            return \Cart::getContent();
        }
        $createOrder = OrderModel::insert([
            'orders_holder'=>$customer=='guest'?'guest': $getcustomer->customer_name,
            'orders_holder_phone'=>$customer=='guest'?'guest': $getcustomer->customer_phone,
            'orders_purchase_price'=> $totalPurchase,
            'orders_sell_price'=> $req->total,
            'orders_discount_price'=> $req->discount,
            'orders_grand_price'=> $req->payable,
        ]);
        \Cart::clear();
        event(new Order('orders',$invoiceOrder));
        return \Cart::getContent();
    }

}