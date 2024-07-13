<?php

namespace App\Http\Livewire;

use App\Models\AdminlogModel;
use Livewire\Component;

class Updatepassword extends Component
{
    public $old_pass, $new_pass;
    protected $rules = [
        'old_pass'=> 'required',
        'new_pass'=> 'required',
    ];
    public function render()
    {
        return view('livewire.updatepassword');
    }
    public function updatePassword(){
        $validated = $this->validate();
        $data = AdminlogModel::where('admin_phone', session()->get('phone'))->where('admin_password', md5($this->old_pass))->count();
        if($data != 1){
            $this->old_pass ='';
            $this->new_pass = '';
            $this->dispatchBrowserEvent('updateNotPassword',[]);
            return;
        }
        $update = AdminlogModel::where('admin_phone', session()->get('phone'))->where('admin_password', md5($this->old_pass))->update([
            'admin_password'=> md5($this->new_pass)
        ]);
        $this->old_pass ='';
        $this->new_pass = '';
        $this->dispatchBrowserEvent('updatePassword',[]);
    }
}
