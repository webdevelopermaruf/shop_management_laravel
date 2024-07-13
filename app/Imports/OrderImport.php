<?php

namespace App\Imports;

use App\Models\OrderModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class OrderImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new OrderModel([
            'orders_holder'     => $row['Customer']==null?'guest':$row['Customer'],
            'orders_holder_phone'    => $row['Mobile']==null?'guest':'0'.$row['Mobile'], 
            'orders_purchase_price'    => 0, 
            'orders_sell_price'  => $row['Price'],
            'orders_discount_price'  => $row['Discount'],
            'orders_grand_price'  => $row['Total'],
            'orders_creation'  => date('y-m-d H:i:s', strtotime($row['Created'])),
        ]);
    }
}
