<div id="form_section">
    <div class="form-validation">
        <form class="form-valide" wire:submit.prevent='addcategory' onsubmit="return false">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-categoryName">
                    Category Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="val-categoryName" name="val_categoryName"
                        wire:model.defer='name' placeholder="Enter a Category Name">
                    @error('name')
                        <span class="text-danger error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-description">
                    Description
                </label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" id="val-description" name="val_description"
                        wire:model.defer='desc' placeholder="Description..">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" id='categoryAdd' class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>