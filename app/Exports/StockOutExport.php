<?php

namespace App\Exports;

use App\Models\ProductModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class StockOutExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $stockout = ProductModel::where('product_qty', 0)->get();
        return view('Export.stockOutexport', [
            'stock'=> $stockout,
        ]);
    }
}
