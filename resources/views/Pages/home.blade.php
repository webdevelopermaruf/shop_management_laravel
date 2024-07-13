@extends('Layout.App')
@section('title', 'Dashboard')

@section('content')
    <section class="dash-main-widget-box">
        <div class="row">
            <div class="col-sm-3 si-box-padding">
                <div class="dash-box">
                    <h2 id="todaysell" class="text-success">{{ $properties['todaysell'] }}</h2>
                    <p>Total Sell <span>Today</span></p>
                    <div class="control-in-dc above-box">
                    </div>
                </div>
                <!-- end of dash-box -->
            </div>

            <!-- end of si-box-padding -->
            <div class="col-sm-3 si-box-padding">
                <div class="dash-box">
                    <h2 id="todayinv" class="text-danger">{{ $properties['todayinvoice'] }}</h2>
                    <p>Invoice Generated <span>Today</span></p>
                    <div class="control-in-dc down-box">
                    </div>
                </div>
                <!-- end of dash-box -->
            </div>
            <!-- end of si-box-padding -->

            <!-- end of si-box-padding -->
            <div class="col-sm-3 si-box-padding">
                <div class="dash-box">
                    <h2 id="todayqty" class="text-info">{{ $properties['todayproductsellQty'] }}</h2>
                    <p>Product Sold<span>Today</span></p>
                    <div class="control-in-dc down-box">
                    </div>
                </div>
                <!-- end of dash-box -->
            </div>
            <div class="col-sm-3 si-box-padding">
                <div class="dash-box">
                    <h2 id="todaynewcus" class="text-warning">{{ $properties['todaynewCustomer'] }}</h2>
                    <p>New Customer <span>Today</span></p>
                    <div class="control-in-dc above-box">
                    </div>
                </div>
                <!-- end of dash-box -->
            </div>
            <!-- end of si-box-padding -->
        </div>
        <!-- end of row -->
    </section>
    <section class="merchant-table row">
        <div class="col-md-12 si-box-padding">
            <div class="border-table widget-wrapper-sm">
                <div class="table-head clearfix">
                    <p class="pull-left">Recent Orders</p>
                    <a href="{{ url('/quick-order') }}" class="btn sm-custom-btn pull-right">View more</a>
                </div>
                <div class="table-responsive">
                    <table class="table sm-custom-table">
                        <thead>
                            <tr>
                                <th width='25%'>Customer Name</th>
                                <th width='15%'>Customer Phone</th>
                        @if(session()->get('role') <= 1)
                                <th width='15%'>Purchase Price</th>
                        @endif
                                <th width='15%'>Discount Price</th>
                                <th width='15%'>Sell Price</th>
                                <th width='25%'>Order Time</th>
                            </tr>
                        </thead>
                        <tbody id="ordertBody">
                            @foreach ($orders as $order)
                                <tr>
                                    <td style="text-transform:Capitalize">{{ $order->orders_holder }}</td>
                                    <td>{{ $order->orders_holder_phone }}</td>
                        @if(session()->get('role') <= 1)
                                    <td>{{ $order->orders_purchase_price }}</td>
                        @endif
                                    <td>{{ $order->orders_discount_price }}</td>
                                    <td>{{ $order->orders_grand_price }}</td>
                                    <td>{{ $order->orders_creation }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- end of sm-custom-table -->
                </div>
                <!-- end of table-responsive -->
            </div>
            <!-- end of border-table -->
        </div>
        <!-- end of col-md-12 -->
    </section>
    <!-- end of merchant-table -->
    <section style="display: none" class="small-widget">
        <h3>Quick Report</h3>
        <div class="row">
            <div class="col-md-3 si-box-padding">
                <div class="small-box-widget clearfix">
                    <div class="small-icon-box invoice-box">
                        <i class="ti-write"></i>
                    </div>
                    <div class="small-para-box">
                        <p><span>12000</span> Today Profit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 si-box-padding">
                <div class="small-box-widget clearfix">
                    <div class="small-icon-box merchants-box">
                        <i class="ti-bar-chart"></i>
                    </div>
                    <div class="small-para-box">
                        <p><span> {{ $properties['todaysell'] }} </span>Today Sell</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 si-box-padding">
                <div class="small-box-widget clearfix">
                    <div class="small-icon-box receipt-box">
                        <i class="ti-medall-alt"></i>
                    </div>
                    <div class="small-para-box">
                        <p><span>230 Receipt</span>This Month Profit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 si-box-padding">
                <div class="small-box-widget clearfix">
                    <div class="small-icon-box user-box">
                        <i class="ti-bar-chart"></i>
                    </div>
                    <div class="small-para-box">
                        <p><span>60 New User</span>This Month Sell</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('jsfile')
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script>
        var pusher = new Pusher('{{ config('services.pusher.key') }}', {
            cluster: 'ap2'
        });

        var Orderchannel = pusher.subscribe('order-channel');
        Orderchannel.bind('order-event', function(data) {
            if (data.order == 'orders') {
                axios.get('/updated').then(function(res) {
                    $('#todaysell').html(res.data.todaysell)
                    $('#todayinv').html(res.data.todayinvoice)
                    $('#todayqty').html(res.data.todayproductsellQty)
                    $('#todaynewcus').html(res.data.todaynewCustomer)
                });
                var tableBody = '';
                axios.get('/recall/order').then(function(res) {
                    var counter = 0;
                    for (const order of res.data) {
                        counter++;
                        if (counter >= 11) {
                            break;
                        }
                        tableBody += `<tr>
                                <td style="text-transform:Capitalize">${order.orders_holder}</td>
                                <td>${order.orders_holder_phone}</td>
                        @if(session()->get('role') <= 1)
                                <td>${order.orders_purchase_price}</td>
                        @endif
                                <td>${order.orders_discount_price}</td>
                                <td>${order.orders_grand_price }</td>
                                <td>${order.orders_creation }</td>
                            </tr>`;
                    }
                    $('#myTable').dataTable().fnClearTable();
                    $('#myTable').dataTable().fnDestroy();
                    document.querySelector("#ordertBody").innerHTML = tableBody;
                    $('#myTable').dataTable().draw();
                });
            }
        });
    </script>
@endpush
