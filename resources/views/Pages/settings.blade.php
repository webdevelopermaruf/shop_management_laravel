@extends('Layout.App')

@section('title', 'App Settings')

@section('content')
    <section class="customer-table row">
        <div class="col-md-12 si-box-padding">
            <div class="data-table-wrapper border-table widget-wrapper-sm">
                <div class="table-head clearfix data-table-head">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#settings">App Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content" style="padding: 10px">
                        <div id="settings" class="tab-pane fade in active">
                            @livewire('appsettings')
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('jsfile')
    <script>
        var type = true;
        $(".editsettings").on('click', function() {
            if (type == true) {
                document.querySelectorAll(".readonlyfor").forEach(element => {
                    element.removeAttribute('readonly');
                    element.removeAttribute('disabled');
                    type = false;
                });
            } else {
                document.querySelectorAll(".readonlyfor").forEach(element => {
                    element.setAttribute('readonly');
                    element.setAttribute('disabled');
                    type = true;

                });
            }

        });
    </script>
@endpush
