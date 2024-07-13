@extends('Layout.App')

@section('title', 'Customer')

@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#home">All Cutomers</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu1">Add customer</a>
                        </li>
                    </ul>
                </div>
                <!-- end of table-head -->

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
                                        <th width='30%'>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        @if (session()->get('role') <= 2)
                                            <th width='20%'>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>
                                                <div class="config-content checkbox-config-div">
                                                    <input id="check-{{ $customer->customer_id }}" type="checkbox"
                                                        value="{{ $customer->customer_id }}">
                                                    <label for="check-{{ $customer->customer_id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $customer->customer_id }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>{{ $customer->customer_phone }}</td>
                                            <td>{{ $customer->customer_email }}</td>
                                            <td>{{ $customer->customer_address }}</td>
                                            @if (session()->get('role') <= 2)
                                                <td>
                                                    <button onclick='getdata({{ $customer->customer_id }})'
                                                        class="ti-pencil-alt btn btn-lg text-success" data-toggle="modal"
                                                        data-target="#editModal"></button>
                                                    @if (session()->get('role') <= 1)
                                                        <button onclick="delcustomer({{ $customer->customer_id }})"
                                                            class="ti-trash btn btn-lg text-danger"></button>
                                                    @endif

                                                </td>
                                            @endif
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
                                        <h4 class="modal-title">Edit customer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="" for="u_customer_name">
                                                Customer Name
                                            </label><span class="text-danger">*</span>
                                            <input type="text" class="form-control" id="u_customer_name"
                                                name="u_customer_name" placeholder="Customer Name..">
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="u_customer_phone">
                                                Customer Phone
                                            </label></label><span class="text-danger">*</span>
                                            <input type="text" class="form-control" id="u_customer_phone"
                                                name="u_customer_phone" placeholder="Customer Phone">
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="u_customer_email">
                                                Customer Email
                                            </label>
                                            <input type="text" class="form-control" id="u_customer_email"
                                                name="u_customer_email" placeholder="Customer Email">
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="u_customer_address">
                                                Customer Address
                                            </label>
                                            <input type="text" class="form-control" id="u_customer_address"
                                                name="u_customer_address" placeholder="Customer Address">
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
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @livewire('addcustomer')
                    </div>
                </div>
                <!-- end of table-responsive -->
            </div>
            <!-- end of data-table-wrapper -->
        </div>
        <!-- end of si-box-padding -->
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
        var pusher = new Pusher('{{ config('services.pusher.key') }}', {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('customer-channel');
        channel.bind('customer-event', function(data) {
            var tableBody = '';
            if (data.customer == 'customers') {
                axios.get('/customer/recall').then(function(res) {
                    for (let customer of res.data) {
                        tableBody += `<tr>
                       <td>
                            <div class="config-content checkbox-config-div">
                                 <input id="check-${customer.customer_id}" type="checkbox"
                                    value="${customer.customer_id}">
                                <label for="check-${customer.customer_id}"></label>
                            </div>
                        </td>
                        <td>${customer.customer_id}</td>
                        <td>${customer.customer_name}</td>
                        <td>${customer.customer_phone}</td>
                        <td>${customer.customer_email==null?'':customer.customer_email}</td>
                        <td>${customer.customer_address==null?'':customer.customer_address}</td>
                        @if (session()->get('role') <= 2)
                        <td>
                            <button onclick='getdata( ${customer.customer_id} )' class="ti-pencil-alt btn btn-lg text-success"
                            data-toggle="modal" data-target="#editModal"></button>
                            @if (session()->get('role') <= 1)
                            <button onclick="delcustomer(${customer.customer_id})"  class="ti-trash btn btn-lg text-danger"></button>
                            @endif
                        </td>
                        @endif
                    </tr>`;

                    }
                    $('#myTable').dataTable().fnClearTable();
                    $('#myTable').dataTable().fnDestroy();
                    document.querySelector('tbody').innerHTML = tableBody;
                    $('#myTable').dataTable().draw();
                })
            }

        });
    </script>

    <script>
        function getdata(id) {
            axios.get('{{ url()->current() }}/edit/' + id)
                .then(function(res) {
                    document.querySelector('#u_customer_name').value = res.data.customer_name;
                    document.querySelector('#u_customer_phone').value = res.data.customer_phone;
                    document.querySelector('#u_customer_email').value = res.data.customer_email;
                    document.querySelector('#u_customer_address').value = res.data.customer_address;
                    document.querySelector('#submitbtnupd').setAttribute('onclick', 'editcustomer(' + res.data
                        .customer_id + ")");
                })
        }

        function editcustomer(id) {
            var name = document.querySelector("#u_customer_name");
            var phone = document.querySelector("#u_customer_phone");
            var email = document.querySelector("#u_customer_email");
            var address = document.querySelector("#u_customer_address");
            axios.put('{{ url()->current() }}/update/' + id, {
                name: name.value,
                phone: phone.value,
                email: email.value,
                address: address.value,
            }).then(function(res) {
                if (res.data == 'done') {
                    toastr.info('Customer Updated Successfully');
                } else {
                    toastr.error('Something Is Wrong!');
                }
            })
        }

        function delcustomer(id) {
            var conf = confirm('Are You Sure To Delete?');
            if (conf == true) {

                axios.delete('{{ url()->current() }}/delete/' + id)
                    .then(function(res) {
                        if (res.data == "done") {
                            toastr.error('Customer Deleted Successfully');
                        } else {
                            toastr.error('Something Is Wrong!');
                        }
                    })
            }
        }
    </script>
@endpush
