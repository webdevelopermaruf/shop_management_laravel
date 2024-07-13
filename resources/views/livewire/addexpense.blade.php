<div id="form_section">
    <div class="form-validation">
        <form class="form-valide" wire:submit.prevent='addExpense' onsubmit="return false">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-expensesName">
                    Expenses Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control text-capitalize" id="val-expensesName"
                        name="expensesName" wire:model.defer='expensesName' placeholder="Enter a Expenses Name">
                    @error('expensesName')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-customerphone">
                    Expenses Type
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="val-expenseType" name="val-expenseType"
                        wire:model.defer='expenseType' list="typesExpense" placeholder="Enter Expense Type">
                        <datalist id="typesExpense">
                            <option value="Monthly Bill"></option>
                            <option value="Salary"></option>
                        </datalist>
                    @error('expenseType')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-expenseAmount">
                    Expense Amount
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="number" class="form-control" id="val-expenseAmount" name="val-expenseAmount"
                        wire:model.defer='expenseAmount' placeholder="Enter a Expenses Amount">
                    @error('expenseAmount')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-expensedate">
                    Expense Date
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control date" id="val-expensedate" name="val-expensedate" 
                        wire:model.defer='expensedate' placeholder="Enter Expense Date">
                    @error('expensedate')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" id='expenseAdd' class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
