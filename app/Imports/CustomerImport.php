<?php

namespace App\Imports;

use App\Models\CustomerModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class CustomerImport implements ToModel, WithHeadingRow
{
   
    public function model(array $row)
    {
        return new CustomerModel([
            'customer_name'     => $row['Name'],
            'customer_phone'    => '0'.$row['Mobile'], 
            'customer_email'    => $row['Email'], 
            'customer_address'  => $row['Address'],
        ]);
    }
}
