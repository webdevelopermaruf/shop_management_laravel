<?php

namespace App\Http\Controllers;

use App\Models\AdminlogModel;
use App\Models\CustomerModel;
use App\Models\InvoiceModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties=array();
        $properties['todaysell'] = OrderModel::whereDate('orders_creation', date('y-m-d'))->sum('orders_grand_price');
        $properties['todayinvoice'] = OrderModel::whereDate('orders_creation', date('y-m-d'))->count();
        $properties['todayproductsellQty'] = InvoiceModel::whereDate('invoice_creation', date('y-m-d'))->sum('invoice_qty');
        $properties['todaynewCustomer'] = CustomerModel::whereDate('customer_creation', date('y-m-d'))->count();

       return view('Pages.home',['orders'=>OrderModel::latest('orders_creation')->take(10)->get(), 'properties'=>$properties]);
    }

   
    public function updated()
    {
        $properties=array();
        $properties['todaysell'] = OrderModel::whereDate('orders_creation', date('y-m-d'))->sum('orders_grand_price');
        $properties['todayinvoice'] = OrderModel::whereDate('orders_creation', date('y-m-d'))->count();
        $properties['todayproductsellQty'] = InvoiceModel::whereDate('invoice_creation', date('y-m-d'))->sum('invoice_qty');
        $properties['todaynewCustomer'] = CustomerModel::whereDate('customer_creation', date('y-m-d'))->count();

        return $properties;
    }
    public function profile()
    {

        return view('Pages.profile',['admins'=>AdminlogModel::all()]);
    }
    public function settings()
    {
        return view('Pages.settings');
    }
}
