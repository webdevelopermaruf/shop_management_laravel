<?php

namespace App\Http\Controllers;

use App\Events\Category;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index()
    {
        $categories = CategoryModel::all();
        return view('Pages.category', ['categories' => $categories]);
    }


    public function updatecategory(Request $req, $id)
    {
        $update = CategoryModel::where('category_id', $id)->update([
            'category_name' => $req->name,
            'category_desc' => $req->desc,
        ]);
        if ($update == true) {
            event(new Category(CategoryModel::all()));
            return 'done';
        } else {
            return 'fail';
        }
    }


    public function delcategory($id)
    {
        $category = CategoryModel::where('category_id', $id)->delete();
        if ($category == true) {
            event(new Category(CategoryModel::all()));
            return 'done';
        } else {
            return 'fail';
        }
    }


    public function getcategory($id)
    {
        $category = CategoryModel::where('category_id', $id)->first();
        return $category;
    }
}
