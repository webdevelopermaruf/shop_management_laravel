<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Shoppi Admin</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- themify css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/themify/themify-icons.css') }}">
    <!-- mCustomScrollbar css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/mCustomScrollbar/jquery.mCustomScrollbar.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <!-- custom style css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <section class="login-outer-wrapper">
        <div class="login-top-bg">
        </div>
        <div class="login-bottom-bg"></div>
        
            @error('error')
            <div id="toast-container" class="toast-top-right">
                <div class="toast toast-error" aria-live="assertive" style="display: block;">
                    <div class="toast-message">Login Crediential Wrong</div>
                </div>
            </div>
            @enderror
        <form method="POST" action="{{url('/auth/authenticate')}}" class="login">
            @csrf
            <div class="login-head">
                <img src="" alt="">
                <h2>Welcome !<span> {{$site->site_name}}</span></h2>
                <p>Sign in with credentials</p>
            </div>
            <div class="login-credential-wrapper">
                <div class="login-input-wrapper clearfix">
                    <div class="icon-box">
                        <i class="ti-email"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="admin_phone" placeholder="Phone Number">
                    </div>
                </div>
            </div>
            <div class="login-credential-wrapper">
                <div class="login-input-wrapper clearfix">
                    <div class="icon-box">
                        <i class="ti-lock"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="admin_password" placeholder="Password">
                    </div>
                </div>
                <div class="row forget-wrapper clearfix">
                    <div class="col-sm-12">
                        <a href="tel:+8801746803899" disabled class="text-center">Forgot Password?</a>
                    </div>
                </div>
            </div>
            <div class="btn-wrapper-sign">
                <button type="submit" class="btn text-white sign-in-btn">Sign in</button>
            </div>
        </form>
    </section>
</body>

</html>
