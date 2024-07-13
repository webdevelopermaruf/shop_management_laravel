@extends('Layout.App')

@section('title', 'Stock Out')

@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#home">Stock Out Product</a>
                        </li>
                        @if(session()->get('role') < 2)
                        <li>
                            <a target="_blank" href="{{url('app/export/stockout/product')}}" style="padding:10px 20px" class="btn btn-primary exportbtn" id="excelInventory">Export</a>                          
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="home" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table id="myTable" class="display custom-table-data">
                                <thead>
                                    <tr>
                                        <th>Product Id</th>
                                        <th width='30%'>Product Name</th>
                                        <th>Barcode</th>
                                        <th>Product Qty</th>
                                        <th>Purchase Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stockOut as $product)
                                        <tr>
                                           <td>{{$product->product_id}}</td>
                                           <td>{{$product->product_name}}</td>
                                           <td>{{$product->product_barcode}}</td>
                                           <td>{{$product->product_qty}}</td>
                                           <td>{{$product->product_purchase_price}}</td>
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
@endsection

@push('jsfile')
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script>
        toastr.options.closeButton = true;
        window.addEventListener('customerAdded', event => {
            toastr.success('customer Added Successfully');
        });
        window.addEventListener('Error', event => {
            toastr.error('Something Went Wrong!');
        });
        // var pusher = new Pusher('{{ config('services.pusher.key') }}', {
        //     cluster: 'ap2'
        // });

    </script>
@endpush
