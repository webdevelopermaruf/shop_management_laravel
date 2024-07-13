@extends('Layout.App')

@section('title', 'Return Order')

@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#allReturnOrder">Returned Orders</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="allReturnOrder" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table id="myTable" class="display custom-table-data">
                                <thead>
                                    <tr>
                                        <th width='10%' style="padding: 0 25px;">
                                            <input id="selectAll" type="checkbox">
                                        </th>
                                        <th width='25%'>Customer Name</th>
                                        <th width='20%'>Customer Phone</th>
                                        <th width='10%'>Qty</th>
                                        <th width='10%'>Returned Money</th>
                                        <th width='20%'>Date</th>
                                        <th width='5%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($returnorders as $order)
                                        <tr>
                                            <td>
                                                <div class="config-content checkbox-config-div">
                                                    <input id="check-{{ $order->ro_id }}" type="checkbox"
                                                        value="{{ $order->ro_id }}">
                                                    <label for="check-{{ $order->ro_id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $order->ro_cus_name }}</td>
                                            <td>{{ $order->ro_cus_phone }}</td>
                                            <td>{{ $order->ro_qty }}</td>
                                            <td>{{ $order->ro_money }}</td>
                                            <td>{{ $order->ro_creation }}</td>
                                            <td>
                                                <button onclick='getdata({{$order->ro_id}},"{{$order->ro_cus_name}}","{{$order->ro_cus_phone}}",{{$order->ro_money}})'
                                                    class="ti-eye btn btn-lg text-info" data-toggle="modal"
                                                    data-target="#returnProductModal"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- return product modal starts --}}
    <div id="returnProductModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Return Products</h4>
                </div>
                <div class="modal-body">
                    <section class="invoice-design-sec white-smooth-wrapper no-margin">
                        <div class="invoice-head">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Products</h2>
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
                                    <p style="text-transform: capitalize" id="customer_information"></p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h4>Returned Time</h4>
                                    <p id="returnTime"></p>
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
                                                <th>Product Barcode</th>
                                                <th>Return Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody id="returnBox">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-footer">
                            <div class="row">
                                <div class="col-md-5">
                                </div>
                                <div class="col-md-7">
                                    <div class="invoice-total">
                                        <ul>
                                            <li>
                                                <p>Total Return Amount</p>
                                            </li>
                                            <li>
                                                <h3 id="returnedPriceTotal"></h3>
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
    {{-- return product modal ends --}}

@endsection
@push('jsfile')
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script>
        function getdata(order_id,name,phn,money) {
            $("#customer_information").html(name+'<br>'+phn);
            axios.get('/return-order/select/products/' + order_id)
            .then(function(res) {
                let content ='';
                for (const key in res.data) {
                        content += `<tr>
                            <td>${res.data[key].ro_product_name}</td>
                            <td>${res.data[key].ro_product_barcode}</td>
                            <td>${res.data[key].return_qty}</td>
                        </tr>`;
                    }

                    $("#returnBox").html(content);
                    $("#returnTime").html(res.data[0].rp_creation);
                    $("#returnedPriceTotal").html(money);
                })
        }
    </script>
@endpush
