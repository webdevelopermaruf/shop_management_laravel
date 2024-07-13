<?php

namespace App\Http\Livewire;

use App\Events\Category;
use App\Models\CategoryModel;
use Livewire\Component;

class Addcategory extends Component
{
    public $name, $desc;

    public function render()
    {
        return view('livewire.addcategory');
    }

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function resetAll()
    {
        $this->name = '';
        $this->desc = '';
    }


    public function addcategory()
    {

        $validatedData = $this->validate();
        $addcategory = CategoryModel::insert([
            'category_name'=> trim($this->name),
            'category_desc'=> trim($this->desc),
            'category_items'=> 0,
        ]);
        if($addcategory == true){
            event(new Category(CategoryModel::all()));
            $this->resetAll();
            $this->dispatchBrowserEvent('CategoryAdded', []);
        }else{
            $this->dispatchBrowserEvent('Error', []);

        }
       
    }

   
}
