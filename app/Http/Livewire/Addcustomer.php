<?php

namespace App\Http\Livewire;

use App\Events\Customer;
use App\Models\CustomerModel;
use Livewire\Component;

class Addcustomer extends Component
{
    public $name, $customer_phone, $email, $address;
    protected $rules= [
        'name'=> 'required',
        'customer_phone'=> 'required|unique:customers|regex:/(01)[0-9]{9}$/',
    ];
    public function render()
    {
        return view('livewire.addcustomer');
    }

    
    public function resetAll()
    {
        $this->name= '';
        $this->customer_phone= '';
        $this->email= '';
        $this->address= '';
    }
    public function addCustomer(){
        $validated = $this->validate();
        $addcustomer = CustomerModel::insert([
            'customer_name' => trim($this->name),
            'customer_phone' => $this->customer_phone,
            'customer_email' => $this->email,
            'customer_address' => $this->address,
        ]);

        if($addcustomer == true){
            event(new Customer('customers'));
            $this->resetAll();
            $this->dispatchBrowserEvent('customerAdded',[]);
        }else{
            $this->resetAll();
            $this->dispatchBrowserEvent('Error',[]);
        }
    }
}
