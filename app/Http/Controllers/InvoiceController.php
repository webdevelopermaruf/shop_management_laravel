<?php

namespace App\Http\Controllers;

use App\Models\InvoiceModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        return InvoiceModel::where('invoice_order_no', $id)->get();
    }

    public function getSell($id)
    {
        return OrderModel::where('orders_id', $id)->first();
    }
}
