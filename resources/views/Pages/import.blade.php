@extends('Layout.App')

@section('title', 'Import')

@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#customer">Customer Importer</a>
                        </li>
                        <li class=''>
                            <a data-toggle="tab" href="#product">Product Importer</a>
                        </li>
                          <li class=''>
                            <a data-toggle="tab" href="#order">Order Importer</a>
                        </li>
                    </ul>
                </div>
                <!-- end of table-head -->

                <div class="tab-content" style="padding: 10px">
                    <div id="customer" class="tab-pane fade  in active">
                        <div id="form_section">
                            <div class="form-validation">
                                <form enctype="multipart/form-data" method="POST"
                                    action="{{ url()->current() . '/customer' }}" class="form-valide">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label" for="customerfile">
                                            Upload Customer File
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <input type="file" class="form-control" id="customerfile" name="customerfile"
                                                placeholder="upload a file" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div>
                                            <button type="submit" id='customerAdd' class="btn btn-primary">Upload
                                                File</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="product" class="tab-pane fade">
                        <div id="form_section">
                            <div class="form-validation">
                                <form enctype="multipart/form-data" method="POST"
                                    action="{{ url()->current() . '/product' }}" class="form-valide">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label" for="productfile">
                                            Upload Product File
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <input type="file" class="form-control" id="productfile" name="productfile"
                                                placeholder="upload a file" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div>
                                            <button type="submit" id='customerAdd' class="btn btn-primary">Upload
                                                File</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="order" class="tab-pane fade">
                        <div id="form_section">
                            <div class="form-validation">
                                <form enctype="multipart/form-data" method="POST"
                                    action="{{ url()->current() . '/order' }}" class="form-valide">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label" for="orderfile">
                                            Upload Order File
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <input type="file" class="form-control" id="orderfile" name="orderfile"
                                                placeholder="upload a file" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div>
                                            <button type="submit" id='customerAdd' class="btn btn-primary">Upload
                                                File</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    @if (session('fileuploadstatus'))
        <script>
            toastr.info("{{ session('fileuploadstatus') }}");
        </script>
    @endif
@endpush
