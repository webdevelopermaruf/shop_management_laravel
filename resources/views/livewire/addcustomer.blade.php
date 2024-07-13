<div id="form_section">
    <div class="form-validation">
        <form class="form-valide" wire:submit.prevent='addCustomer' onsubmit="return false">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-customerName">
                    Customer Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control text-capitalize" id="val-customerName"
                        name="val_customerName" wire:model.defer='name' placeholder="Enter a Customer Name">
                    @error('name')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-customerphone">
                    Customer Phone
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="val-customerphone" name="val_customerphone"
                        wire:model.defer='customer_phone' placeholder="Enter a Customer phone" inputmode="tel">
                    @error('customer_phone')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-customerEmail">
                    Customer Email
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="val-customerEmail" name="val_customerEmail"
                        wire:model.defer='email' placeholder="Enter a Customer Email">
                    @error('email')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-customerAddress">
                    Customer Address
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="val-customerAddress" name="val_customerAddress"
                        wire:model.defer='address' placeholder="Enter a Customer Address">
                    @error('address')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" id='customerAdd' class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
