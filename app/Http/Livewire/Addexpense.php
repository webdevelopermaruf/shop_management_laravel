<?php

namespace App\Http\Livewire;

use App\Events\Expense;
use App\Models\ExpenseModel;
use Livewire\Component;

class Addexpense extends Component
{
    public $expensesName,$expenseType,$expenseAmount,$expensedate;

    public function render()
    {
        $this->expensedate = date('Y-m-d');
        return view('livewire.addexpense');
    }
    protected $rules = [
        'expensesName'=> 'required',
        'expenseType'=> 'required',
        'expenseAmount'=> 'required',
        'expensedate'=> 'required',
    ];
    public function resetAll()
    {
        $this->expensesName = '';
        $this->expenseType = '';
        $this->expenseAmount = '';
        $this->expensedate = '';
    }
    public function addExpense()
    {
        $validated = $this->validate();
        $addexpense = ExpenseModel::insert([
            'expenses_name'=> $this->expensesName,
            'expenses_type'=> $this->expenseType,
            'expenses_amount'=> $this->expenseAmount,
            'expenses_date'=> $this->expensedate,
        ]);
        if($addexpense == true){
            event(new Expense('expenses'));
            $this->resetAll();
            $this->dispatchBrowserEvent('expenseAdded',[]);
        }else{
            $this->resetAll();
            $this->dispatchBrowserEvent('Error',[]);
        }
    }
}
