@extends('Layout.App')

@section('title', 'Profile')

@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#personal">Personal Information</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#admins">Admins & Roles</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#password">Change Password</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="personal" class="tab-pane fade in active">
                        @livewire('adminpersonal')
                    </div>
                    <div id="admins" class="tab-pane fade">
                        <div class="table-responsive">
                            <table id="myTable" class="display custom-table-data">
                                <thead>
                                    <tr>

                                        <th>Admin Name</th>
                                        <th width='12%'>Designation</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th width='35%'> Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->admin_name }}</td>
                                            <td>
                                                @if ($admin->admin_role == 0)
                                                  <span class="badge badge-success">Developer</span>  
                                                @elseif($admin->admin_role == 1)
                                                  <span class="active bg-success">Admin</span>  
                                                @elseif($admin->admin_role == 2)
                                                  <span class="inactive bg-success">Manager</span>  
                                                @elseif($admin->admin_role == 3)
                                                  <span class="pending bg-success">Sales Man</span>  
                                                @endif
                                            </td>
                                            <td>{{ $admin->admin_phone }}</td>
                                            <td>{{ $admin->admin_email }}</td>
                                            <td>{{ $admin->admin_address }}</td>
                                            <td>@if ($admin->admin_role == 0)
                                                Full Controll & Debag
                                              @elseif($admin->admin_role == 1)
                                                Access All Function (Add / Edit / Delete)
                                              @elseif($admin->admin_role == 2)
                                                Access All Function (Add / Edit)
                                              @elseif($admin->admin_role == 3)
                                                Specific Function (Add/ Edit)
                                              @endif</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="password" class="tab-pane fade">
                        @livewire('updatepassword')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('jsfile')
    <script>
        window.addEventListener('UpdatedProfile', event => {
            toastr.success('Profile Updated Successfully');
        });
    </script>
@endpush
