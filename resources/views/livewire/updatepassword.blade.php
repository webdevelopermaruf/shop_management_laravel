<div id="form_section">
    <div class="form-validation">
        <form class="form-valide" wire:submit.prevent='updatePassword' onsubmit="return false">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-categoryName">
                    Type Old Password
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12 input-group" style="padding-left: 15px">
                    <input type="password" class="form-control" id="val-old_pass" name="old_pass"
                        wire:model.defer='old_pass' placeholder="Enter Old Password">
                    <span class="btn input-group-addon" onclick="eye(this)">
                        <i class="ti-eye"></i>
                    </span>
                </div>
                @error('old_pass')
                    <span style="padding-left: 15px;" class="text-danger error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-categoryName">
                    Type New Password
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12 input-group" style="padding-left: 15px">
                    <input type="password" class="form-control" id="val-new_pass" name="new_pass"
                        wire:model.defer='new_pass' placeholder="Enter New Password">
                    <span class="btn input-group-addon" onclick="eye(this)">
                        <i class="ti-eye"></i>
                    </span>
                </div>
                @error('new_pass')
                    <span style="padding-left: 15px;" class="text-danger error">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" id='changePwd' class="btn btn-info">Change Password</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('jsfile')
    <script>
        function eye(item) {
            var itembox = item.closest('div');
            if (itembox.querySelector('input').type == 'password') {
                itembox.querySelector('input').setAttribute('type', 'text');
            } else {
                itembox.querySelector('input').setAttribute('type', 'password');
            }
        }
        window.addEventListener('updatePassword', event => {
            toastr.info('Password Updated Successfully');
        });
        window.addEventListener('updateNotPassword', event => {
            toastr.error('Old Password Wrong');
        });
    </script>
@endpush
