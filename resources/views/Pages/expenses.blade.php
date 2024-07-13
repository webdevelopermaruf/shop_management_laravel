@extends('Layout.App')

@section('title', 'Expenses')
@push('cssfile')
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.css') }}">
@endpush
@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#allexpenses">Expenses</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#addexpense">Add Expense</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="allexpenses" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table id="myTable" class="display custom-table-data">
                                <thead>
                                    <tr>
                                        <th width='10%' style="padding: 0 25px;">
                                            <input id="selectAll" type="checkbox">
                                        </th>
                                        <th width='25%'>Expenses</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $item)
                                        <tr>
                                            <td>
                                                <div class="config-content checkbox-config-div">
                                                     <input id="check-{{$item->expenses_id}}" type="checkbox"
                                                        value="{{$item->expenses_id}}">
                                                    <label for="check-{{$item->expenses_id}}"></label>
                                                </div>
                                            </td>
                                            <td>{{$item->expenses_name}}</td>
                                            <td>{{$item->expenses_type}}</td>
                                            <td>{{$item->expenses_amount}}</td>
                                            <td>{{$item->expenses_date}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="addexpense" class="tab-pane fade">
                        @livewire('addexpense')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('jsfile')
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script>
        toastr.options.closeButton = true;
        window.addEventListener('expenseAdded', event => {
            toastr.success('Expenses Added Successfully');
        });
        window.addEventListener('Error', event => {
            toastr.error('Something Went Wrong!');
        });
        var pusher = new Pusher('{{ config('services.pusher.key') }}', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('expense-channel');
        channel.bind('expense-event', function(data) {
            var tableBody = '';
            if (data.expense == 'expenses') {
                axios.get('/expenses/recall').then(function(res) {
                    for (let expense of res.data) {
                        tableBody += `<tr>
                       <td>
                            <div class="config-content checkbox-config-div">
                                 <input id="check-${expense.expenses_id}" type="checkbox"
                                    value="${expense.expenses_id}">
                                <label for="check-${expense.expenses_id}"></label>
                            </div>
                        </td>
                        <td>${expense.expenses_name}</td>
                        <td>${expense.expenses_type}</td>
                        <td>${expense.expenses_amount}</td>
                        <td>${expense.expenses_date}</td>
                    </tr>`;

                    }
                    $('#myTable').dataTable().fnClearTable();
                    $('#myTable').dataTable().fnDestroy();
                    document.querySelector('tbody').innerHTML = tableBody;
                    $('#myTable').dataTable().draw();
                })
            }
        });
        $('.date').datepicker({
            format: 'yyyy-MM-dd',
            startView: 1,
            autoHide: true,
        });
    </script>
@endpush
