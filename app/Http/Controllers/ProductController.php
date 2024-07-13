<?php

namespace App\Http\Controllers;

use App\Events\Product;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductController extends Controller
{
    public function index()
    {
        return view('Pages.product', ['products' => ProductModel::all(), 'categories' => CategoryModel::all()]);
    }
    public function getproduct($id)
    {
        $product = ProductModel::where('product_id', $id)->first();
        return $product;
    }
    public function recall()
    {
        return ProductModel::all();
    }
    
    public function updateproduct(Request $req, $id)
    {
        $update = ProductModel::where('product_id', $id)->update([
            'product_name' => $req->product,
            'product_category' => $req->category == null ? 0 : $req->category,
            'product_purchase_price' => $req->purchase,
            'product_sell_price' => $req->sell,
            'product_qty' => $req->qty,
        ]);

        if ($update == true) {
            event(new Product('products'));
            return 'done';
        } else {
            return "fail";
        }
    }
    public function delproduct($id)
    {
        $product = ProductModel::where('product_id', $id)->delete();
        if ($product == true) {
            event(new Product('products'));
            return 'done';
        } else {
            return 'fail';
        }
    }
    public function searchProduct(Request $req)
    {
        $keyword = $req->keyword;
        $getdata = ProductModel::where('product_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('product_barcode', 'LIKE', '%' . $keyword . '%')
            ->orWhere('product_sku', 'LIKE', '%' . $keyword . '%')->take(7)->get();

        return $getdata;
    }
    public function inventory()
    {
        $inventory = ProductModel::where('product_qty', '>', 0)->get();
        $qty = ProductModel::sum('product_qty');
        $price = 0;
        $data = ProductModel::all();
        foreach ($data as $item) {
            $price  += $item->product_qty * $item->product_purchase_price;
        }

        return view('Pages.inventory', ['inventory' => $inventory, 'qty' => $qty, 'price' => $price]);
    }
    public function outofstock()
    {
        $stockOut = ProductModel::where('product_qty', 0)->get();
        return view('Pages.outofstock', ['stockOut' => $stockOut]);
    }

    public function generateBarcode($code, $qty)
    {
        $sitename = SiteSettings::where('site_no', 1)->pluck('site_name')[0];
        $product = ProductModel::where('product_barcode', $code)->first();
        if ($product == null) {
            return 'empty';
        }
        return view('Print.barcodelabel', ['code' => $code, 'product' => $product, 'qty' => $qty, 'sitename' => $sitename]);
    }
    public function viewProduct($id)
    {
        $getdata = ProductModel::where('product_id', $id)->first();
        return $getdata;
    }
    public function viewProductBarcode(Request $req)
    {
        $getdata = ProductModel::where('product_barcode', $req->barcode)->first();
        return $getdata;
    }
    public function incrementProduct(Request $req)
    {
        $update = ProductModel::where('product_barcode', $req->barcode)->update([
            'product_purchase_price' => $req->purchase,
            'product_sell_price' => $req->sell,
            'product_qty' => $req->qty,
        ]);
        if($update == true){
            event(new Product('products'));
            return 'done';
        }
    }
}
