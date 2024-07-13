<?php

namespace App\Http\Controllers;

use App\Models\ExpenseModel;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    function index(){
        $expenses = ExpenseModel::orderBy('expenses_date', 'desc')->get();
        return view('Pages.expenses',['expenses'=>$expenses]);
    }
    function recall()
    {
        return ExpenseModel::all();
    }
}
