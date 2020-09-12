<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="WECAN - Week of Creativity and Innovation" name="description" />
        <meta content="WECAN" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.css')}}" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-primary bg-pattern">
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="mt-4 text-center">
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-6">
                                    @yield('gambar')
                                </div>
                            </div>
    
                            <h1 class="mt-5 text-uppercase text-white font-weight-bold mb-3">@yield('header')</h1>
                            <h5 class="text-white-50">@yield('message')</h5>
                            <div class="mt-5">
                                <a class="btn btn-success waves-effect waves-light" href="{{ app('router')->has('home') ? route('home') : url('/') }}">{{ __('Go Home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end Account pages -->

        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>


        <script src="{{asset('assets/js/app.js')}}"></script>
    </body>
</html>
