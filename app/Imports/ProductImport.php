<?php

namespace App\Imports;

use App\Models\ProductModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');


class ProductImport implements ToModel ,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductModel([
            'product_name' => $row['Name'],
            'product_category' => $row['Category'],
            'product_barcode' => $row['Barcode'],
            'product_sku' => $row['Sku'],
            'product_qty' => $row['Quantity'],
            'product_sold' => $row['Sold'],
            'product_purchase_price' => $row['Factory_price'],
            'product_sell_price' => $row['Price'],
        ]);
    }
}
