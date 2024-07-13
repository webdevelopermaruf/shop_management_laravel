<?php

namespace App\Http\Livewire;

use App\Events\Product;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class Addproduct extends Component
{
    use WithFileUploads;

    public $generate;

    public $productname, $category, $barcode, $product_sku, 
    $purchase_price, $sell_price, $qty, $withtick;

    public $photo;

    public function mount(){
        $this->barcode = "6".time();
    }

    public function updatedPhoto(){
        $this->validate([
            'photo' => 'image',
        ]);
    }
    
    public function render()
    {
        return view('livewire.addproduct',['categories'=>CategoryModel::all()]);
    }

    protected $rules=[
        'productname'=>'required|min:3',
        'category'=>'required',
        'barcode'=>'required',
        'product_sku'=>'required|unique:products',
        'purchase_price'=>'required',
        'sell_price'=>'required',
        'qty'=>'required',
    ];
     
    public function resetAll()
    {
        $this->productname = '';
        $this->category = '';
        $this->barcode = "6".time();
        $this->product_sku = '';
        $this->purchase_price = '';
        $this->sell_price = '';
        $this->qty = '';
        $this->photo = null;
        $this->withtick = null;
    }

    
    public function addProduct(){
        $validated = $this->validate();
        if($this->photo != null){
            $path = $this->photo->store('public/products');
            $item = (explode('/',$path));
            $newpath = $item[1]."/".$item[2];

            $addcategory = ProductModel::insert([
                'product_name'=> trim($this->productname),
                'product_category'=> $this->category,
                'product_barcode'=> $this->barcode,
                'product_sku'=> $this->product_sku,
                'product_purchase_price'=> $this->purchase_price,
                'product_sell_price'=> $this->sell_price,
                'product_qty'=> $this->qty,
                'product_image'=> $newpath,
            ]); 
            if($addcategory == true){
                event(new Product('products'));
                $this->resetAll();
                $this->dispatchBrowserEvent('ProductAdded',[]);
            }else{
                $this->dispatchBrowserEvent('Error',[]);
            }
            
        }else{
            $addcategory = ProductModel::insert([
                'product_name'=> trim($this->productname),
                'product_category'=> $this->category,
                'product_barcode'=> $this->barcode,
                'product_sku'=> $this->product_sku,
                'product_purchase_price'=> $this->purchase_price,
                'product_sell_price'=> $this->sell_price,
                'product_qty'=> $this->qty,
            ]); 
            if($addcategory == true){
                event(new Product('products'));
                $this->dispatchBrowserEvent('ProductAdded',['withtick'=>$this->withtick,'code'=>$this->barcode,'qty'=>$this->qty]);
                $this->resetAll();
            }else{
                $this->dispatchBrowserEvent('Error',[]);
            }
        }
       
    }

}
