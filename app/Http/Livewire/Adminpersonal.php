<?php

namespace App\Http\Livewire;

use App\Models\AdminlogModel;
use Livewire\Component;

class Adminpersonal extends Component
{
    public $admin_name, $admin_email, $admin_password, $admin_address;

    protected $rules= [
        'admin_name'=> 'required',
        'admin_email'=> 'required',
        'admin_address'=> 'required',
    ];

    public function mount(){
        $this->admin_name = session()->get('name');
        $this->admin_email = session()->get('email');
        $this->admin_address = AdminlogModel::where('admin_phone', session()->get('phone'))->first()->admin_address;
    }

    public function render()
    {
        return view('livewire.adminpersonal');
    }

    public function updateadmin(){
        $validated = $this->validate();
        $update = AdminlogModel::where('admin_phone', session()->get('phone'))->update([
            'admin_name'=> $this->admin_name,
            'admin_email'=> $this->admin_email,
            'admin_address'=> $this->admin_address,
        ]);
        session()->put('name', $this->admin_name);
        session()->put('email', $this->admin_email);
        $this->dispatchBrowserEvent('UpdatedProfile',[]);
    }
   
}