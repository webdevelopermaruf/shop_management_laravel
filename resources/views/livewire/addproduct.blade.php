@php
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
@endphp
<form class="form-valide" wire:submit.prevent='addProduct' method="post" onsubmit="return false">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-productName">
                    Product Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control text-capitalize" id="val-productName"
                     name="productname" wire:model.defer='productname'
                        placeholder="Enter a Product Name">
                    @error('productname')<span class="text-danger error">The product name required</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-categoryName">
                    Category Name
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <select class="form-control" name="category" wire:model.defer='category'>
                        <option value="" selected>Select A Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category')<span class="text-danger error">{{$message}}</span>@enderror

                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-productCode">
                    Product Barcode
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="val-productCode"
                     name="barcode" wire:model.defer="barcode" placeholder="Enter a Product BarCode" value="{{ '6' . ($time = time()) }}" readonly>
                        @error('barcode')<span class="text-danger error">Barcode is required</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-sku">
                    Product Sku
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="val-sku" name="product_sku" wire:model.defer="product_sku"
                        placeholder="Enter a Product Sku">
                @error('product_sku')<span class="text-danger error">
                    {{$message}}</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-purchasePrice">
                    Purchase Price
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <input type="number" class="form-control" id="val-purchasePrice" 
                    name="purchase_price" wire:model.defer="purchase_price"
                        placeholder="Enter Purchase Price">
                @error('purchase_price')<span class="text-danger error">
                The purchase price is required</span>@enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-sellPrice">
                    Sell Price
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <input type="number" class="form-control" id="val-sellPrice" name="sell_price" wire:model.defer="sell_price"
                        placeholder="Enter Sell Price">
                @error('sell_price')<span class="text-danger error">
                            The sell price is required</span>@enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-lg-6 col-md-7 col-sm-6">
                    {!! $generator->getBarcode(strval($barcode), $generator::TYPE_CODE_128, 2, 100) !!}
                </div>
                @if($photo)
                <img src="{{ $photo->temporaryUrl() }}" style="width: 100px;margin-bottom: 25px;"  alt="preview_img" id="preview_product_img">
                @else
                <img src="{{asset('storage/products/default.jpg')}}" style="width: 100px;margin-bottom: 25px;"  alt="preview_img" id="preview_product_img">
                @endif
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-productImage">
                    Product Image
                </label>
                <div class="input-group mb-3 col-xl-6">
                    <div class="custom-file">
                        <input type="file" wire:model='photo' 
                         class="custom-file-input" name="product_image" accept="image/*"> 
                            {{-- onchange="readURL(this)"> --}}
                        <label class="custom-file-label">Upload
                            Image</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="val-productQty">
                    Product Qty
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-8">
                    <input type="number" class="form-control" id="val-productQty" name="qty" wire:model.defer='qty'
                        placeholder="Enter a Product Qty">
                @error('qty')<span class="text-danger error">
                            The product quantity is required</span>@enderror
                </div>
            </div>
            <div class="form-group row" style="margin-top:20px;">
                <div class="col-lg-4 col-form-label">
                    <div class="config-content checkbox-config-div">
                        <input id="check-qty" name="check-qty" wire:model.defer='withtick'
                         type="checkbox" value="1">
                        <label for="check-qty">With Barcode Print</label>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
    <div class="form-group pull-right mt-4">
        <div class="col-lg-12 ">
            <button type="submit" class="btn btn-primary float-right">Save</button>
        </div>
    </div>
</form>

@push('jsfile')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview_product_img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
