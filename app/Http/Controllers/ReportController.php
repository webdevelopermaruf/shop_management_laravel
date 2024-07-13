<?php

namespace App\Http\Controllers;

use App\Models\ExpenseModel;
use App\Models\OrderModel;
use App\Models\ReturnOrderModel;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitReport()
    {
        return view('Pages.report');
    }
    public function generateReport($first, $last){
        $order = OrderModel::whereBetween('orders_creation', [$first.' 00:00:00', $last.' 23:59:59'])->get();
        $site = SiteSettings::where('site_no',1)->get()[0];
        $sell = $order->sum('orders_grand_price');
        $factory = $order->sum('orders_purchase_price');
        return view('Print.profitSell',['orders'=>$order,'factory'=> $factory,'sell'=>$sell,
        'first'=>$first, 'last'=>$last, 'site'=> $site ]);
    }
    public function viewOrdersReport($first, $last){
        $order = OrderModel::whereBetween('orders_creation', [$first.' 00:00:00', $last.' 23:59:59'])->get();
        $site = SiteSettings::where('site_no',1)->get()[0];
        $sell = $order->sum('orders_grand_price');
        $factory = $order->sum('orders_purchase_price');
        return view('Print.viewordersreport',['orders'=>$order,'factory'=> $factory,'sell'=>$sell,
        'first'=>$first, 'last'=>$last, 'site'=> $site ]);
    }
    public function monthlyReport($month)
    {
        $first = $month.'-01 00:00:00';
        $last =  $month.'-31 23:59:59';
        $order = OrderModel::whereBetween('orders_creation', [$first, $last])->get();
        $return = ReturnOrderModel::whereBetween('ro_creation', [$first, $last])->sum('ro_money');
        $costs = ExpenseModel::whereBetween('expenses_date', [$first, $last])->sum('expenses_amount');
        $site = SiteSettings::where('site_no',1)->get()[0];

        $purchase =  $order->sum('orders_purchase_price');
        $sells =  $order->sum('orders_grand_price');
        // $profit = $orders_sell_price - $orders_purchase_price;

        return view('Print.modernmonthlyreport',['site'=>$site,'purchase'=>$purchase,'sell'=>$sells,'expense'=>$costs,'return'=>$return,'month'=>$month]);

    }
   
}