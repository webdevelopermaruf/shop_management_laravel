@extends('Layout.App')

@section('title', 'Report')
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
                            <a data-toggle="tab" href="#dayReport">Day Report</a>
                        </li>
                        @if(session()->get('role') <= 1)
                        <li>
                            <a data-toggle="tab" href="#form_admin">Admin Report</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#form_month">Monthly Report</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-content" style="padding: 10px">
                    <div id="dayReport" class="tab-pane fade in active">
                        <div id="form_section" class="form-validation">
                            <h4 class="text-center">Sells Report</h4>
                            <form class="form-valide" onsubmit="return false">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="sellesDateFirst">
                                        From
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control date" id="sellesDateFirst"
                                         placeholder="Ex: YYYY-MM-DD" value="{{date('Y-m-d')}}" 
                                         autocomplete="off" inputmode="none">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="sellesDateLast">
                                        To
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control date" id="sellesDateLast"
                                         placeholder="Ex: YYYY-MM-DD" value="{{date('Y-m-d')}}" 
                                         autocomplete="off" inputmode="none">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <button type="submit" onclick="getOrdersData()" 
                                        class="btn btn-primary">
                                        Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(session()->get('role') <= 1)
                    <div id="form_admin" class="tab-pane fade">
                        <div id="form_section" class="form-validation">
                            <h4 class="text-center">Admin Profit Report</h4>
                            <form class="form-valide" onsubmit="return false">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-categoryName">
                                        From
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control date" id="startdate" name="start_date"
                                            placeholder="Ex: YYYY-MM-DD" autocomplete="off" inputmode="none">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-description">
                                        To
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control date" id="todate" name="finish_date"
                                            placeholder="Ex: YYYY-MM-DD" autocomplete="off" inputmode="none">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <button type="submit" onclick="genarateProfit()" class="btn btn-primary">Generate
                                            Profit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="form_month" class="tab-pane fade">
                        <div id="form_section" class="form-validation">
                            <h4 class="text-center">Monthly Report</h4>
                            <form class="form-valide" onsubmit="return false">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="monthlydata">
                                        Select Month
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control dateMonth" id="monthlydata"
                                         placeholder="Ex: YYYY-MM" value="{{date('Y-m')}}" 
                                         autocomplete="off" inputmode="none">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <button type="submit" onclick="getMonthlyData()" 
                                        class="btn btn-primary">
                                        Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('jsfile')
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script>
        $('.date').datepicker({
            format: 'yyyy-MM-dd',
            startView: 1,
            autoHide: true,
        });
        $('.dateMonth').datepicker({
            format: 'yyyy-MM',
            startView: 1,
            autoHide: true,
        });
        
        function genarateProfit() {
            var first = $('#startdate').val();
            var last = $('#todate').val();
            if (first != '' && last != '') {
                var url = '/generate/profit/' + first + '/' + last;
                window.open(url, "_blank", "scrollbars=1,resizable=1,height=800,width=1000");
            }
        }

        function getOrdersData() {
            var first = $('#sellesDateFirst').val();
            var last = $('#sellesDateLast').val();
            if (first != '' && last != '') {
                var url = '/generate/order/report/' + first + '/' + last;
                window.open(url, "_blank", "scrollbars=1,resizable=1,height=800,width=1000");
            }
        } 
        
        function getMonthlyData() {
            var month = $('#monthlydata').val();
            if (month != '') {
                var url = '/generate/monthly/report/' + month;
                window.open(url, "_blank", "scrollbars=1,resizable=1,height=800,width=1000");
            }
        }
    </script>
@endpush
