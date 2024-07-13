@extends('Layout.App')

@section('title', 'Product')
@push('cssfile')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush
@section('content')
    <section class="category-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="">
                            <a data-toggle="tab" href="#oldproduct">Existing Product</a>
                        </li>
                        <li class="active">
                            <a data-toggle="tab" href="#home">All Products</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu1">Add Product</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="home" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table id="myTable" class="display custom-table-data">
                                <thead>
                                    <tr>
                                        <th width='10%' style="padding: 0 25px;">
                                            <input id="selectAll" type="checkbox">
                                        </th>
                                        <th>Id</th>
                                        <th width='20%'>Product Name</th>
                                        <th>Barcode</th>
                                        <th>Sku</th>
                                        <th>Quantity</th>
                                        <th width='10%'>Sell Price</th>
                                        <th width='20%'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="config-content checkbox-config-div">
                                                    <input id="check-{{ $product->product_id }}" type="checkbox"
                                                        value="{{ $product->product_id }}">
                                                    <label for="check-{{ $product->product_id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $product->product_id }}</td>
                                            <td class="text-capitalize">{{ $product->product_name }}</td>
                                            <td>{{ $product->product_barcode }}</td>
                                            <td>{{ $product->product_sku }}</td>
                                            <td>{{ $product->product_qty }}</td>
                                            <td title="{{ $product->product_purchase_price }}">{{ $product->product_sell_price }}</td>
                                            <td>
                                            @if (session()->get('role') <= 2)
                                                <button onclick='getdata({{ $product->product_id }})'
                                                    class="ti-pencil-alt btn btn-lg text-success" data-toggle="modal"
                                                    data-target="#editModal"></button>
                                                @if (session()->get('role') <= 1)
                                                    <button onclick="delProduct({{ $product->product_id }})"
                                                        class="ti-trash btn btn-lg text-danger"></button>
                                                @endif
                                            @endif
                                            <button onclick="printlabel({{ $product->product_barcode }})"
                                                class="btn btn-lg text-warning">
                                            <img width="24px" src="{{asset('images/barcodeprinter.png')}}" alt="">
                                            </button>
                                            <button onclick='listtable("{{ $product->product_barcode }}" , "{{ $product->product_name }}")'
                                                    class="ti-wand btn btn-lg text-primary" data-toggle="modal"
                                                    data-target="#listModal" title="Product Sells Report"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- edit modal  --}}
                        <div id="editModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Product</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="" for="u_product_name">
                                                Product Name
                                            </label>
                                            <input type="text" class="form-control" id="u_product_name"
                                                name="u_product_name" placeholder="Product Name..">
                                        </div>
                                        <div class="form-group">
                                            <label for="u_product_category">
                                                Category Name
                                            </label>
                                            <select class="form-control" id="u_product_category" name="u_product_category">
                                                <option value="">Select a Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->category_id }}">
                                                        {{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="u_purchase_price">
                                                Purchase Price
                                            </label>
                                            <input type="number" class="form-control" id="u_purchase_price"
                                                name="u_purchase_price" placeholder="Purchase Price">
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="u_sell_price">
                                                Sell Price
                                            </label>
                                            <input type="number" class="form-control" id="u_sell_price" name="u_sell_price"
                                                placeholder="Sell Price">
                                        </div>
                                        <div class="form-group">
                                            <label class="">
                                                Product Qty
                                            </label>
                                            <input type="number" class="form-control" id="u_product_qty"
                                                name="u_product_qty" placeholder="Product Qty">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button id="submitbtnupd" onclick="" type="button"
                                            class="btn btn-primary btn-default" data-dismiss="modal">Submit</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        {{-- list modal --}}
                        <div id="listModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Product Details Sells</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Product Name: <b id="productLabelOfList"></b></h4>
                                        <table class="table table-stripped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th>Sold Price</th>
                                                    <th>Qty</th>
                                                    <th>Sold Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pdetailslisttable"></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @livewire('addproduct')
                    </div>
                    <div id="oldproduct" class="tab-pane fade">
                        <div id="form_section">
                            <div class="form-validation">
                                <form class="form-valide" id="existingform" onsubmit="return false">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="itemorbarcode">
                                            Product Name / Barcode 
                                        </label>
                                        <div class="col-lg-12">
                                            <div class="autocomplete">
                                            </div>
                                            <input onkeyup="keyupSuggestion(this)" oninput="barcodeReader(this)" class="form-control"
                                                type="text" name="item" id="itemorbarcode" placeholder="Item name/Barcode"
                                                autofocus autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="factory">
                                            Factory Price 
                                        </label>
                                        <div class="col-lg-12">
                                           <input type="number" class="form-control outindecator"
                                           placeholder="Type Factory Price" id="ex_factory">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="sellPrice">
                                            Sell Price 
                                        </label>
                                        <div class="col-lg-12">
                                           <input type="number" class="form-control outindecator"
                                           placeholder="Type Sell Price" id="ex_sellPrice">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="quantity">
                                           Quantity 
                                        </label>
                                        <div class="col-lg-12">
                                           <input type="number" class="form-control outindecator"
                                           placeholder="Type Quantity" id="ex_quantity" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="newquantity">
                                           New Quantity 
                                        </label>
                                        <div class="col-lg-12">
                                           <input type="number" class="form-control outindecator"
                                           placeholder="Quantity" id="newquantity">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div style="margin-left: 18px;margin-top: 15px;" class="config-content checkbox-config-div">
                                            <input id="e_withTick" type="checkbox" value="1">
                                            <label for="e_withTick">With Print Barcode</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <button type="submit" onclick="addExistsNew()" class="btn btn-warning">
                                                Add Product
                                            </button>
                                            <button type="reset" class="btn btn-danger pull-right resetdisabled">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('jsfile')
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}

    <script>
        $("#single-select").select2();

        window.addEventListener('ProductAdded', event => {
            toastr.success('Product Added Successfully');
            if(event.detail.withtick != null){
            window.open('/generate/barcode/'+event.detail.code+'/'+event.detail.qty, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
            }
        });

        var pusher = new Pusher('{{ config('services.pusher.key') }}', {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('product-channel');
        channel.bind('product-event', function(data) {
            var tableBody = '';
            if (data.product == 'products') {
                axios.get('/product/recall').then(function(res) {
                    for (let product of res.data) {
                        tableBody += `<tr>
                    <td width='10%'>
                        <div class="config-content checkbox-config-div">
                            <input id="check-${product.product_id}" type="checkbox"
                                value="${product.product_id}">
                            <label for="check-${product.product_id}"></label>
                        </div>
                    </td>
                    <td>${product.product_id}</td>
                    <td width='28%'>${product.product_name}</td>
                    <td>${product.product_barcode}</td>
                    <td>${product.product_sku}</td>
                    <td>${product.product_qty}</td>
                    <td width='15%' title='${product.product_purchase_price}'>${product.product_sell_price}</td>
                    <td width='20%'>
                        @if (session()->get('role') <= 2)
                        <button onclick='getdata(${product.product_id})'
                            class="ti-pencil-alt btn btn-lg text-success" data-toggle="modal"
                            data-target="#editModal"></button>
                            @if (session()->get('role') <= 1)
                                 <button onclick="delProduct(${product.product_id})"
                                 class="ti-trash btn btn-lg text-danger"></button>
                            @endif
                            @endif
                        <button onclick="printlabel(${product.product_barcode})"
                        class="ti-printer btn btn-lg text-warning"></button>
                   
                    </td>
                </tr>`
                    }

                    $('#myTable').dataTable().fnClearTable();
                    $('#myTable').dataTable().fnDestroy();
                    document.querySelector('tbody').innerHTML = tableBody;
                    $('#myTable').dataTable().draw();
                    
                });
            }
        });
    </script>
    <script>
        function getdata(id) {
            axios.get('{{ url()->current() }}/edit/' + id)
                .then(function(res) {
                    document.querySelector('#u_product_name').value = res.data.product_name;
                    document.querySelector('#u_product_category').value = res.data.product_category;
                    document.querySelector('#u_purchase_price').value = res.data.product_purchase_price;
                    document.querySelector('#u_sell_price').value = res.data.product_sell_price;
                    document.querySelector('#u_product_qty').value = res.data.product_qty;
                    // document.querySelector('#u_product_img').value = res.data.product_image;
                    document.querySelector('#submitbtnupd').setAttribute('onclick', 'editProduct(' + res.data
                        .product_id + ")");
                })
        }

        function editProduct(id) {
            var product = document.querySelector("#u_product_name");
            var category = document.querySelector("#u_product_category");
            var purchase = document.querySelector("#u_purchase_price");
            var sell = document.querySelector("#u_sell_price");
            var qty = document.querySelector("#u_product_qty");
            axios.put('{{ url()->current() }}/update/' + id, {
                product: product.value,
                category: category.value,
                purchase: purchase.value,
                sell: sell.value,
                qty: qty.value,
            }).then(function(res) {
                if (res.data == 'done') {
                    toastr.info('Product Updated Successfully');
                } else {
                    toastr.error('Something Is Wrong!');
                }
            })
        }

        function delProduct(id) {
            var conf = confirm('Are You Sure To Delete?');
            if (conf == true) {

                axios.delete('{{ url()->current() }}/delete/' + id)
                    .then(function(res) {
                        if (res.data == 'done') {
                            toastr.error('Product Deleted Successfully');
                        } else {
                            toastr.error('Something Is Wrong!');
                        }
                    });
            } else {
                return 0;
            }
        }
        function printlabel(code){
            var qty = prompt('Quantity?');
            if(qty != null &&  isNaN(qty)==false){
                window.open('/generate/barcode/'+code+'/'+qty, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
            }
            
        }
        function printbarcode(){
            var code = $("#pbarcode").val();
            var qty = $("#barcodepqty").val();
            window.open('/generate/barcode/'+code+'/'+qty, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
        }
        function keyupSuggestion(content) {
            if (content.value != '') {
                var optionBody = '<ul class="auto-complete-input-menu">';
                axios.post('/barcode/get', {
                    keyword: content.value,
                }).then(function (res) {
                    for (let item of res.data) {
                        optionBody += `<li onclick='viewOldProduct(${item.product_id})'>${item.product_name}</li>`
                    }
                    optionBody += `</ul>`;
                    $(".autocomplete").html(optionBody);
                })
             }else {
                 $(".autocomplete").html('');
            }
        }
        function viewOldProduct(id){
            $(".autocomplete").html('');
            axios.get('/view/existing/product/'+id).then(function(res){
                $("#itemorbarcode").val(res.data.product_barcode);     
                $("#itemorbarcode").attr('readonly','');     
                $("#ex_factory").val(res.data.product_purchase_price);     
                $("#ex_sellPrice").val(res.data.product_sell_price);     
                $("#ex_quantity").val(res.data.product_qty);  
            })
        }
        function barcodeReader(item) {
            if (item.value.length >= 10) {
                 $(".autocomplete").html('');
                axios.post('/view/existing/product/barcode/', {
                    barcode: item.value,
                }).then(function (res) {
                    console.log(res.data);
                    if(res.data == null || res.data == ''){
                        return;
                    }else{
                        $(".autocomplete").html('');     
                        $("#itemorbarcode").val(res.data.product_barcode);     
                        $("#itemorbarcode").attr('readonly','');     
                        $("#ex_factory").val(res.data.product_purchase_price);     
                        $("#ex_sellPrice").val(res.data.product_sell_price);     
                        $("#ex_quantity").val(res.data.product_qty);   
                    }
                     
                })
            }
            if(item.value.length == ''){
                $(".autocomplete").html('');
            }
        }
        function addExistsNew(){
            var code = $('#itemorbarcode').val();
            var factory  = $('#ex_factory').val();
            var sell  = $('#ex_sellPrice').val();
            var olditem  = $('#ex_quantity').val();
            var newitem  = $('#newquantity').val();
            var tick  = $('#e_withTick').prop('checked');
            
            if(code != '' && factory != ''  && sell != ''  && olditem != ''  && newitem != '' ){
                axios.post('/add/existing/product/barcode',{
                    barcode: code,
                    purchase: factory,
                    sell: sell,
                    qty: parseInt(olditem) + parseInt(newitem),
                }).then(function(res){
                    if(res.data == 'done'){
                        toastr.success('Product Added Successfully');
                        if(tick == true){
                            window.open('/generate/barcode/'+code+'/'+newitem, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
                        }
                        $("#existingform").trigger('reset');
                        $('#itemorbarcode').removeAttr('readonly');
                    }
                })
            }else{
                alert('please do not blank any field');
            }
        }
        $('.resetdisabled').on('click',function(){
            $("#itemorbarcode").removeAttr('readonly');     

        });
        
        function listtable(code, name){
            var pdetailslisttable = document.querySelector("#pdetailslisttable");
            document.querySelector("#productLabelOfList").innerHTML = name;
            axios.get('/productlist/'+code)
            .then((res)=>{
                var database = res.data;
                var tableBody = ""
                for(let i =0; i < database.length; i++){
                    tableBody += `<tr>
                     <td title="${database[i].invoice_holder_phone}">${database[i].invoice_holder}</td>
                     <td>${database[i].invoice_paid}</td>
                     <td>${database[i].invoice_qty}</td>
                     <td>${database[i].invoice_creation}</td>
                    </tr>`;
                }
                pdetailslisttable.innerHTML = tableBody;

            })
            
        }
    </script>
@endpush
