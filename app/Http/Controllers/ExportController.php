<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Exports\ProductInvertoryExport;
use App\Exports\StockOutExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function inventoryProduct()
    {
        return Excel::download(new ProductInvertoryExport, date("y-m-d").'_Product_Inventory.xlsx');
    }
    public function stockOutProduct()
    {
        return Excel::download(new StockOutExport, date("y-m-d").'_Product_StockOut.xlsx');
    }
}
