<?php

namespace App\Http\Controllers;

use App\Events\Customer;
use App\Models\CustomerModel;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
       
        return view('Pages.customer',['customers'=>CustomerModel::all()]);
    }
    public function recall(){
        return CustomerModel::all();
    }
    public function getcustomer($id)
    {
       $getcustomer = CustomerModel::where('customer_id', $id)->first();
       return $getcustomer;
    }

    public function updatecustomer(Request $req, $id){
        $update = CustomerModel::where('customer_id', $id)->update([
            'customer_name'=> $req->name,
            'customer_phone'=> $req->phone,
            'customer_email'=> $req->email,
            'customer_address'=> $req->address,
        ]);

        if($update == true){
            event(new Customer("customers"));
            return 'done';
        }else{
            return "fail";
        }
    }
    public function delcustomer($id){
        $delcustomer = CustomerModel::where('customer_id',$id)->delete();
        if($delcustomer == true){
            event(new Customer("customers"));
            return 'done';
        }else{
            return 'fail';
        }
    }

}
