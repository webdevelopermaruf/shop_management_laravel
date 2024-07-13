<?php

namespace App\Http\Controllers;

use App\Imports\CustomerImport;
use App\Imports\OrderImport;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ImportController extends Controller
{
    public function productView()
    {
        return view('Pages.import');
    }
    public function importCustomer(Request $req)
    {
        $file = $req->file('customerfile');
        if($file == null){
            return redirect()->back();
        }
        Excel::import(new CustomerImport, $file);

        return redirect()->back()->with('fileuploadstatus', 'Customer File Uploaded Successfully');
       
    }
    public function importProduct(Request $req)
    {
        $file = $req->file('productfile');
        if($file == null){
            return redirect()->back();
        }
        Excel::import(new ProductImport, $file);

        return redirect()->back()->with('fileuploadstatus', 'Product File Uploaded Successfully');

    }
    public function importOrder(Request $req)
    {
        $file = $req->file('orderfile');
        if($file == null){
            return redirect()->back();
        }
         Excel::import(new OrderImport, $file);

        // return redirect()->back()->with('fileuploadstatus', 'Order File Uploaded Successfully');

    }
}
