@extends('Layout.App')

@section('title', 'Quick Order')

@push('cssfile')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.css') }}">
    @if (session()->get('role') > 1)
        <style>
            .secr-td {
                display: none !important;
            }
        </style>
    @endif
    <style>
        .modal-body label{
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <section class="row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="">
                            <a data-toggle="tab" href="#returnOrder">Return Order</a>
                        </li>
                        <li class="active">
                            <a data-toggle="tab" href="#create">Create Order</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#recent">Recent Orders</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="returnOrder" class="tab-pane fade">
                        <form onsubmit="return false" class="row searchRecentOrdersForm" style="padding:20px;">
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i class="ti-mobile"></i>
                                    </span>
                                    <input type="text" placeholder="Type Mobile Number" id="return_mobile_search"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i class="ti-agenda"></i>
                                    </span>
                                    <input type="text" placeholder="Type Invoice Number" id="return_invoice_search"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-addon bg-white">
                                        <i class="ti-calendar"></i>
                                    </span>
                                    <input type="text" placeholder="Order Date" id="return_orderdate_search"
                                        class="form-control orderDate" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-4 col-sm-12 mb-3">
                                <button id="ReturnSearchQueryBtn" class="btn btn-info"><i class="ti-search"></i>
                                    Search</button>
                            </div>
                        </form>
                        <div class="d-none searchOrderTable">
                            <div class="table-responsive">
                                <table class="display custom-table-data text-center">
                                    <thead>
                                        <tr>
                                            <td>Order Holder</td>
                                            <td>Phone Number</td>
                                            <td>Total Paid</td>
                                            <td>Order Creation</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody id="SearchedOrdersTbody" style="text-transform:Capitalize">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-none tableEditOrder">
                            <table id="ReturnOrderTable" class="table table-primary table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th width="20%">Product Name</th>
                                        <th width="10%">Barcode</th>
                                        <th width="5%">Sold</th>
                                        <th width="10%">Return Qty</th>
                                        <th width="5%">Paid</th>
                                        <th width="5%">Back</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="OrderEditReturnTbody">
                                </tbody>
                            </table>
                            <div class="boxbuttonReturn text-right">
                                <button data-target="#returnOrderModel" data-toggle="modal" id="getMoneyBack"
                                    class="btn btn-danger">Return Product</button>
                            </div>
                        </div>
                    </div>
                    <div id="create" class="tab-pane fade in active">
                        <div class="row" style="padding:20px;">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-white">
                                            <i class="ti-user"></i>
                                        </span>
                                        <select id="select" type="text" class="select-control customerSelect">
                                            <option value="guest">Walk-in Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->customer_id }}">
                                                    {{ $customer->customer_name }} - {{ $customer->customer_phone }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span data-toggle="modal" data-target="#editModal" class="btn input-group-addon">
                                            <i class="ti-user">+</i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-white">
                                            <i class="ti-credit-card"></i>
                                        </span>
                                        <input onkeyup="" oninput="barcodeReader(this)" class="form-control"
                                            type="text" name="item" id="itemorbarcode"
                                            placeholder="Item name/Barcode" autofocus autocomplete="off" />
                                        <div class="autocomplete">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table class="table table-primary table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th width="35%">Product Name</th>
                                                <th class="d-none">Stock</th>
                                                <th width="25%">Qty</th>
                                                <th width="15%">Price</th>
                                                <th width="10%">Discount</th>
                                                <th width="17%">Subtotal</th>
                                                <th width="2%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartTbody">
                                            <tr class="text-center">
                                                <td colspan="7">
                                                    <img width="300px" src="{{ asset('images/loader.gif') }}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <h4><input type="checkbox" onchange='onsuggest(this)' name="suggestion" id="suggestion">
                                    <label for="suggestion">Show Suggestion</label>
                                </h4>
                                <ul class="order_ul">
                                    @foreach ($favourites as $favourite)
                                        <li onclick="addrow({{ $favourite->product_id }}, {{ $favourite->product_qty }})"
                                            data-productid="{{ $favourite->product_id }}">
                                            <div class="text-center">
                                                <img src="{{ asset('storage') }}/{{ $favourite->product_image }}"
                                                    width="40" alt="">
                                                <p style="margin:3px 0 0 0"> {{ $favourite->product_name }}</p>
                                                <span>{{ $favourite->product_sell_price }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button onclick="clearAll()" class="btn-lg btn btn-danger pull-left">Clear</button>
                                    <button data-toggle="modal" data-target="#payModal" onclick="readyInvoice()"
                                        class="btn-lg btn btn-primary pull-right cashNowBtn">Cash</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="recent" class="tab-pane fade">
                        <div class="table-responsive">
                            <table id="myTable" class="display custom-table-data">
                                <thead>
                                    <tr>
                                        <th width='10%' style="padding: 0 25px;">
                                            <input id="selectAll" type="checkbox">
                                        </th>
                                        <th width='30%'>Customer Name</th>
                                        <th>Phone</th>
                                        @if (session()->get('role') <= 1)
                                            <th>Factory Price</th>
                                        @endif
                                        <th>Sell Price</th>
                                        <th>Order Time</th>
                                        <th width='20%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody id='ordertBody'>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <div class="config-content checkbox-config-div">
                                                    <input id="check-{{ $order->orders_id }}" type="checkbox"
                                                        value="{{ $order->orders_id }}">
                                                    <label for="check-{{ $order->orders_id }}"></label>
                                                </div>
                                            </td>
                                            <td style="text-transform:Capitalize">{{ $order->orders_holder }}</td>
                                            <td style="text-transform:Capitalize">{{ $order->orders_holder_phone }}
                                            </td>
                                            @if (session()->get('role') <= 1)
                                                <td>{{ $order->orders_purchase_price }}</td>
                                            @endif
                                            <td>{{ $order->orders_grand_price }}</td>
                                            <td>{{ $order->orders_creation }}</td>
                                            <td>
                                                <button class="ti-eye btn btn-lg text-dark"
                                                    onclick="updateInvoice({{ $order->orders_id }})" data-toggle="modal"
                                                    data-target="#invoiceModal"></button>
                                                <button class="ti-printer btn btn-lg text-success"
                                                    onclick='print_invoice({{ $order->orders_id }})'
                                                    data-id="{{ $order->orders_id }}"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-center"><button onclick="loadmore30()" class="loadMore btn btn-warning">Load
                                More</button></p>
                    </div>
                </div>

                {{-- modal starts --}}
                <div id="editModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Customer</h4>
                            </div>
                            <div class="modal-body">
                                @livewire('addcustomer')
                            </div>
                        </div>

                    </div>
                </div>
                {{-- modal ends --}}

                {{-- payment modal starts --}}
                <div id="payModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Make Payments</h4>
                            </div>
                            <div class="modal-body">
                                <h3>
                                    <div style="display:flex;justify-content: space-around;">
                                        <div class="Mastitle">
                                            <p>Total Price : </p>
                                            <p>Discount (-): </p>
                                            <p>Total Payable : </p>
                                            <p>Paying : </p>
                                            <p>Return Changes : </p>
                                        </div>
                                        <div class="Masprice">
                                            <p><b class="mtprice" style="color:rgb(73, 227, 148)">0</b></p>
                                            <p><b class="mtdiscount" style="color:red">0</b></p>
                                            <p><b class="mtpayable" style="color:rgb(210, 16, 194)">0</b></p>
                                            <p><b style="color:rgb(12, 37, 50)">
                                                    <input type="number" id='payingId'
                                                        class="form-control no-padding text-left min_width outindecator"
                                                        style="font-size:26px;width:120px;">
                                                </b></p>
                                            <p><b class="returnable" style="color:rgb(19, 36, 225)">0</b></p>
                                            <div class="buttons" style="margin-top: 20px">
                                                {{-- <button style="background:rgb(210, 16, 194);color:white" class="btn">Save
                                            </button> --}}
                                                <button onclick="PaymentClearence(this)"
                                                    style="background:rgb(16, 116, 210);color:white" class="btn">Save &
                                                    Print</button>
                                            </div>
                                        </div>
                                    </div>
                                </h3>

                            </div>
                        </div>

                    </div>
                </div>
                {{-- payment modal ends --}}

                {{-- return Order modal starts --}}
                <div id="returnOrderModel" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Money Return</h4>
                            </div>
                            <div class="modal-body">
                                <form onsubmit="return false" class="returnFinalMoneyBack">
                                    <input type="hidden" id="hid_pre_order_no">
                                    <div class="mb-3">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="return_cus_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Customer Phone</label>
                                        <input type="text" class="form-control" id="return_cus_phn" required>
                                    </div>

                                    <div class="returnInfoChecking">
                                        <h3 class=" text-success">Total Product Return : 
                                            <b class="returnProductItems text-right">0</b>
                                        </h3>
                                        <h3 class=" text-primary">Total Return Money :
                                             <b class="totalReturnedMoney text-right">0</b>
                                            </h3>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-warning exchangeBtnToNewOrder" data-toggle="tab"
                                        href="#create">Exchange / Add Product</button>
                                        <button onclick="returnProductWithMoney()" class="btn btn-danger">Return Money</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- return Order modal ends --}}

                {{-- invoice modal starts --}}
                <div id="invoiceModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Preview Invoice</h4>
                            </div>
                            <div class="modal-body">
                                <section class="invoice-design-sec white-smooth-wrapper no-margin">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2>Invoice</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="invoice-logo-wrapper">
                                                    <img src="{{ asset($site->site_logo) }}" class="img-responsive"
                                                        alt="">
                                                    <div class="invoice-address">
                                                        <p> {{ $site->site_location }} <span>Mobile:
                                                                {{ $site->site_phone }}</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-details text-dark">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Customer Info</h4>
                                                <p style="text-transform: capitalize" id="invoice_customer"></p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <h4>Order Time</h4>
                                                <p id="invoice_order_time"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="invoice-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            @if (session()->get('role') <= 1)
                                                                <th class="right-align-data">Factory</th>
                                                            @endif
                                                            <th class="right-align-data">Sell</th>
                                                            <th class="right-align-data">Qty</th>
                                                            <th class="right-align-data">Discount</th>
                                                            <th class="right-align-data">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="invoiceTbody">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end of invoice-body -->
                                        </div>
                                        <!-- end of col-md-12 -->
                                    </div>
                                    <!-- end of row -->
                                    <div class="invoice-footer">
                                        <div class="row">
                                            <div class="col-md-5">

                                            </div>
                                            <!-- end of col-md-5 -->
                                            <div class="col-md-7">
                                                <div class="invoice-total">
                                                    <ul>
                                                        <li>
                                                            <p>Total Paid Amount</p>
                                                        </li>
                                                        <li>
                                                            <h3 id="paidPriceInvoice"></h3>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-success ti-printer printingInv"
                                                                onclick=""></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- end of invoice-total -->
                                            </div>
                                            <!-- end of col-md-7 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of invoice-footer -->
                                </section>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- invoice modal ends --}}

    </section>
@endsection
@push('jsfile')
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script>
        $('#select').select2();
        var pusher = new Pusher('{{ config('services.pusher.key') }}', {
            cluster: 'ap2'
        });
        var Orderchannel = pusher.subscribe('order-channel');
        var Customerchannel = pusher.subscribe('customer-channel');
        Customerchannel.bind('customer-event', function(data) {
            var customerlist = '<option value="guest">Walk-in Customer</option>';
            if (data.customer == 'customers') {
                axios.get('/customer/recall').then(function(res) {
                    for (let customer of res.data) {
                        console.log(customer);
                        customerlist +=
                            `<option value="${customer.customer_id}">${customer.customer_name} - ${customer.customer_phone}</option>`;
                    }
                    console.log(customerlist);
                    document.querySelector('#select').innerHTML = customerlist;
                    $("#select option:last").attr("selected", "selected");
                    $("#select").select2("destroy").select2();

                })
            }
        });

        Orderchannel.bind('order-event', function(data) {
            print_invoice(data.placedOrder);
            if($(".returnProductItems").html() != 0){
                returnProductWithExchange(data.placedOrder);
            }
            if (data.order == 'orders') {
                var tableBody = '';
                axios.get('/recall/order').then(function(res) {
                    for (const order of res.data) {
                        tableBody += `<tr>
                                <td>
                                    <div class="config-content checkbox-config-div">
                                        <input id="check-${order.orders_id}" type="checkbox"
                                            value="${order.orders_id}">
                                        <label for="check-${order.orders_id}"></label>
                                    </div>
                                </td>
                                <td style="text-transform:Capitalize">${order.orders_holder}</td>
                                <td style="text-transform:Capitalize">${order.orders_holder_phone}</td>
                                @if (session()->get('role') <= 1)
                                <td>${order.orders_purchase_price}</td>
                                @endif
                                <td>${order.orders_grand_price }</td>
                                <td>${order.orders_creation }</td>
                                <td>
                                    <button class="ti-eye btn btn-lg text-dark" data-toggle="modal"
                                    onclick="updateInvoice(${order.orders_id})" 
                                    data-target="#invoiceModal" data-id='${order.orders_id}'></button>
                                    <button class="ti-printer btn btn-lg text-success" onclick='print_invoice(${order.orders_id})' 
                                    data-id='${order.orders_id}'></button>
                                </td>
                            </tr>`;
                    }
                    $('#myTable').dataTable().fnClearTable();
                    $('#myTable').dataTable().fnDestroy();
                    document.querySelector("#ordertBody").innerHTML = tableBody;
                    $('#myTable').dataTable().draw();
                });
            }
        });

        window.addEventListener('customerAdded', event => {
            hideModal('#editModal');
            toastr.success('Customer Added Successfully');
        });

        $('.orderDate').datepicker({
            format: 'yyyy-MM-dd',
            startView: 1,
            autoHide: true,
        });

        //load more 30 days 
        let moreload30 = 1;

        function loadmore30() {
            $('#myTable').dataTable().fnClearTable();
            $('#myTable').dataTable().fnDestroy();
            moreload30++;
            var daystimes = 30 * moreload30;
            var tableBody = "";
            axios.get('/recall/order/' + daystimes).then(function(res) {
                for (const order of res.data) {
                    tableBody += `<tr>
                            <td>
                                <div class="config-content checkbox-config-div">
                                    <input id="check-${order.orders_id}" type="checkbox"
                                        value="${order.orders_id}">
                                    <label for="check-${order.orders_id}"></label>
                                </div>
                            </td>
                            <td style="text-transform:Capitalize">${order.orders_holder}</td>
                            <td style="text-transform:Capitalize">${order.orders_holder_phone}</td>
                            @if (session()->get('role') <= 1)
                            <td>${order.orders_purchase_price}</td>
                            @endif
                            <td>${order.orders_grand_price }</td>
                            <td>${order.orders_creation }</td>
                            <td>
                                <button class="ti-eye btn btn-lg text-dark" data-toggle="modal"
                                onclick="updateInvoice(${order.orders_id})" 
                                data-target="#invoiceModal" data-id='${order.orders_id}'></button>
                                <button class="ti-printer btn btn-lg text-success" onclick='print_invoice(${order.orders_id})' 
                                data-id='${order.orders_id}'></button>
                            </td>
                        </tr>`;
                }
                document.querySelector("#ordertBody").innerHTML = tableBody;
                $('#myTable').dataTable().draw();
            });
        }
    </script>
    <script src="{{ asset('assets/js/orderController.js') }}"></script>
    <script src="{{ asset('assets/js/returnOrderCart.js') }}"></script>
@endpush
