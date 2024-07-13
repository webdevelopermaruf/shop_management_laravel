@extends('Layout.App')

@section('title', 'Category')

@section('content')
    <section class="category-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#home">All Categories</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu1">Add Category</a>
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
                                        <th width='35%'>Category Name</th>
                                        <th width='30%'>Description</th>
                                        <th width='10%'>Items</th>
                                        @if (session()->get('role') <= 2)
                                            <th width='20%'>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="config-content checkbox-config-div">
                                                    <input id="check-{{ $category->category_id }}" type="checkbox"
                                                        value="{{ $category->category_id }}">
                                                    <label for="check-{{ $category->category_id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $category->category_id }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>{{ $category->category_desc }}</td>
                                            <td>{{ $category->category_items }}</td>
                                            @if (session()->get('role') <= 2)
                                                <td>
                                                    <button onclick='getdata({{ $category->category_id }})'
                                                        class="ti-pencil-alt btn btn-lg text-success" data-toggle="modal"
                                                        data-target="#editModal"></button>
                                                    @if (session()->get('role') <= 1)
                                                        <button onclick="delCategory({{ $category->category_id }})"
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
                                        <h4 class="modal-title">Edit Category</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="" for="val-name">
                                                Category Name
                                            </label>
                                            <input type="text" class="form-control" id="u_val-name" name="val_name"
                                                wire:model='u_name' placeholder="Category Name..">
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="val-description">
                                                Description
                                            </label>
                                            <input type="text" class="form-control" id="u_val-desc"
                                                name="val_description" wire:model='u_desc' placeholder="Description..">
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
                        @livewire('addcategory')
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
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}
    <script>
        toastr.options.closeButton = true;
        window.addEventListener('CategoryAdded', event => {
            toastr.success('Category Added Successfully');
        });
        window.addEventListener('Error', event => {
            toastr.error('Something Went Wrong!');
        });
        var pusher = new Pusher('{{ config('services.pusher.key') }}', {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('category-channel');
        channel.bind('category-event', function(data) {
            var tableBody = '';
            for (let category of data.category) {
                tableBody += `<tr>
                       <td>
                            <div class="config-content checkbox-config-div">
                                 <input id="check-${category.category_id}" type="checkbox"
                                    value="${category.category_id}">
                                <label for="check-${category.category_id}"></label>
                            </div>
                        </td>
                        <td>${category.category_id}</td>
                        <td>${category.category_name}</td>
                        <td>${category.category_desc==null?'':category.category_desc}</td>
                        <td>${category.category_items}</td>
                        @if (session()->get('role') <= 2)
                        <td>
                            <button onclick='getdata( ${category.category_id} )' class="ti-pencil-alt btn btn-lg text-success"
                            data-toggle="modal" data-target="#editModal"></button>
                            @if (session()->get('role') <= 1)
                                <button onclick="delCategory(${category.category_id})"  class="ti-trash btn btn-lg text-danger"></button>
                            @endif
                        </td>
                        @endif
                    </tr>`
            }

            $('#myTable').dataTable().fnClearTable();
            $('#myTable').dataTable().fnDestroy();
            document.querySelector('tbody').innerHTML = tableBody;
            $('#myTable').dataTable().draw();
        });
    </script>

    <script>
        function getdata(id) {
            axios.get('{{ url()->current() }}/edit/' + id)
                .then(function(res) {
                    document.querySelector('#u_val-name').value = res.data.category_name;
                    document.querySelector('#u_val-desc').value = res.data.category_desc;
                    document.querySelector('#submitbtnupd').setAttribute('onclick', 'editCategory(' + res.data
                        .category_id + ")");
                })
        }

        function editCategory(id) {
            var name = document.querySelector("#u_val-name");
            var desc = document.querySelector("#u_val-desc");
            axios.put('{{ url()->current() }}/update/' + id, {
                name: name.value,
                desc: desc.value,
            }).then(function(res) {
                toastr.info('Category Updated Successfully');
            })
        }

        function delCategory(id) {
            var conf = confirm('Are You Sure To Delete?');
            if (conf == true) {

                axios.delete('{{ url()->current() }}/delete/' + id)
                    .then(function(res) {
                        toastr.error('Category Deleted Successfully');
                    })
            }
        }
    </script>
@endpush
