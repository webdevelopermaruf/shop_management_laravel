<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title') - Shoppi Admin</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css') }}">
    <!-- themify css -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/themify/themify-icons.css') }}">
    <!-- mCustomScrollbar css -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/mCustomScrollbar/jquery.mCustomScrollbar.css') }}">
    <!-- data table -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/toastr.min.css') }}">
    <!-- custom style css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css') }}">
    @stack('cssfile')
    @livewireStyles

</head>

<body>
    @include('components.header')
    <!-- ================================
         content-outer-wrapper
         ================================-->
    <div class="content-outer-wrapper">
        <div class="chance"></div>
        <!-- end of chance -->
        <section class="profile-page">
            <div class="container">
                <!-- ================================
                  breadcrumbs
                  ================================-->
                <div class="row">
                    <div class="col-md-12 si-box-padding">
                        <section class="common-head-wrapper-sm clearfix">
                            <div class="wrapper-head">
                                <h4>
                                    <span>@yield('title') Page</span>
                                </h4>
                            </div>
                            <!-- end of wrapper-head -->
                            <div class="bread-crumbs">
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">@yield('title')</a></li>
                                </ul>
                            </div>
                            <!-- end of bread-crumbs -->
                        </section>
                        <!-- end of common-head-wrapper-sm -->
                    </div>
                    <!-- end of si-box-padding -->
                </div>
                <!-- end of row -->
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                    <!-- end of col-md-12 -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container -->
        </section>
        <!-- end of profile-page -->
    </div>
    <!-- end of content-outer-wrapper -->
    <!--==============================
         footer
         ==============================-->
    <footer>
        <audio id="clickedsound">
            <source src="{{asset('assets/sound/clickedsound.mp3')}}">
        </audio>
        <audio id="insertsound">
            <source src="{{asset('assets/sound/insertsound.wav')}}">
        </audio>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p>Copyright &copy; 2022-23 . Developed by<a href="https://maruf.bmitfarm.com">
                            Developer Maruf
                        </a>.</p>
                </div>
                <div class="col-sm-6">
                    <ul class="footer-list">
                        <li>All Rights Reserved</li>

                    </ul>
                    <!-- end of footer-list -->
                </div>
                <!-- end of col-md-4 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </footer>
    <!-- end of footer -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS, then Plugins, then Custom js -->
    <!-- Jquery -->
    @livewireScripts
    <script>
        window.livewire.onError(statusCode => {
            toastr.error('Something Went Wrong!');
            return false;
        })
    </script>
    <script src="{{asset('assets/js/jquery-1.12.4.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullscreen.js') }}"></script>
    <!-- bootstrahttps:// -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- mCustomScrollbar css -->
    <script type="text/javascript" src="plugins/mCustomScrollbar/jquery.mCustomScrollbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom js -->
    <script src="assets/js/custom.js"></script>
    <script>toastr.options.closeButton = true;</script>
    @stack('jsfile')
</body>

</html>
