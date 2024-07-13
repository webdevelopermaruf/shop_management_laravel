<div id="form_section">
    <button type="button" class="btn btn-warning ti-pencil pull-right editsettings"
    style="margin-bottom:10px;"></button>
    <div class="form-validation">
        <form class="form-valide" wire:submit.prevent='updateSettings' onsubmit="return false">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-app_name">
                    Shop Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control readonlyfor" id="val-app_name" name="app_name"
                        wire:model.defer='app_name' placeholder="Enter Shop Name" readonly>
                    @error('app_name')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-app_name">
                    Shop Location
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control readonlyfor" id="val-app_location" name="app_location"
                        wire:model.defer='app_location' placeholder="Enter Shop Location" readonly>
                    @error('app_location')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-app_name">
                    Shop Hotline
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control readonlyfor" id="val-app_mobile" name="app_mobile"
                        wire:model.defer='app_mobile' placeholder="Enter Shop Hotline" readonly>
                    @error('app_mobile')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary readonlyfor" disabled readonly>Update Settings</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('jsfile')
<script>
window.addEventListener('updateSettings',event=>{
    toastr.info('Settings Updated!');
});
</script>    
@endpush