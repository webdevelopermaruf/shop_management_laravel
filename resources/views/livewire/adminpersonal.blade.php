<div id="form_section">
    <div class="form-validation">
        <button type="button" class="btn btn-warning ti-pencil pull-right editpersonal"
            style="margin-bottom:10px;"></button>
        <form class="form-valide" wire:submit.prevent='updateadmin' onsubmit="return false">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-categoryName">
                    Full Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control readonlyfor" id="val-adminname" name="admin_name"
                        wire:model.defer='admin_name' placeholder="Enter a Full Name" readonly>
                    @error('admin_name')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-email">
                    Email Address
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control readonlyfor" id="val-email" name="admin_email"
                        wire:model.defer='admin_email' placeholder="Enter a Email Address" readonly>
                    @error('admin_email')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-categoryName">
                    Address
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control readonlyfor" id="val-adminaddress" name="admin_address"
                        wire:model.defer='admin_address' placeholder="Enter Present Address" readonly> 
                    @error('admin_name')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <input type="submit" id='updateInfo' class="btn btn-success readonlyfor" value="Update" disabled>
                </div>
            </div>
        </form>
    </div>
</div>
@push('jsfile')
    <script>
        var type= true;
        $(".editpersonal").on('click',function(){
            if(type == true){
                document.querySelectorAll(".readonlyfor").forEach(element => {
                element.removeAttribute('readonly');
                element.removeAttribute('disabled');
                    type = false;
            });
            }else{
                document.querySelectorAll(".readonlyfor").forEach(element => {
                element.setAttribute('readonly');
                element.setAttribute('disabled');
                type = true;

            });
            }
            
        });
    </script>
@endpush
