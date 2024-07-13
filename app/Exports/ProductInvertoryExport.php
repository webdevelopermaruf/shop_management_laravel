<?php

namespace App\Exports;

use App\Models\ProductModel;
use App\Models\SiteSettings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class ProductInvertoryExport implements FromView ,ShouldAutoSize
{
   
    public function view(): View
    {
        $inventory = ProductModel::where('product_qty','>', 0)->get();
        $site = SiteSettings::where('site_no', 1)->first();
        return view('Export.inventoryexport', [
            'inventories'=> $inventory,
            'site'=>$site,
        ]);
    }
}
