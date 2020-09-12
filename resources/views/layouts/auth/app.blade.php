<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Login | WECAN - Week of Creativity and Innovation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="WECAN - Week of Creativity and Innovation" name="description" />
  <meta content="@bossnanda & apex" name="author" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'WECAN') }}</title>
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">

  <!-- VENDOR CSS -->
  <link rel="stylesheet" href="{{ URL::asset('assets/auth/vendor/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('assets/auth/vendor/font-awesome/css/font-awesome.min.css')}}">
  <!-- Toaster  -->
  <link rel="stylesheet" href="{{ asset('assets/js/toastr/toastr.min.css')}}">
  <!-- MAIN CSS -->
  <link rel="stylesheet" href="{{ URL::asset('assets/auth/css/main.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('assets/auth/css/color_skins.css')}}">
  <style media="screen">
  .auth-main:after{
    content:'';
    position:absolute;
    right:0;top:0;width:100%;
    height:100%;
    z-index:-2;
    background:url(assets/images/2.svg) no-repeat top right  fixed;
  }
  .auth-main::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 400px;
    height: 100%;
    z-index: -1;
    background:transparent;
  }
  .theme-wecan ::selection{
    color:#04b6f9;background: #04b6f9
  }
  body {
    background-color: #04b6f9;
    font-family: "Ubuntu",sans-serif;
    font-size: 14px;
    color: #04b6f9;
  }
  .theme-wecan .page-loader-wrapper{
    background:#04b6f9
  }
  .theme-wecan #left-sidebar .nav-tabs .nav-link.active{
    color:#04b6f9
  }
  .theme-wecan:before,.theme-wecan:after{
    background: #04b6f9
  }
  .theme-wecan #wrapper:before,.theme-wecan #wrapper:after{
    background: #04b6f9
  }
  .theme-wecan .sidebar-nav .metismenu>li.active>a{
    border-left-color:#04b6f9
  }
  .theme-wecan .navbar-nav ul.menu-icon{
    background: #04b6f9
  }
  .theme-wecan .fancy-checkbox input[type="checkbox"]:checked+span:before{
    background: #04b6f9
    ;border-color:#04b6f9
  }
  .theme-wecan .chat-widget li.right .chat-info{
    background: #04b6f9
    ;color:#fff
  }
  .theme-wecan .chat-widget li.right .chat-info:before{
    border-left:10px solid #04b6f9
  }
  .theme-wecan .fc .fc-view-container .fc-view.fc-basic-view>table>thead tr th.fc-widget-header{
    background: #04b6f9
    ;border-color:#04b6f9
    ;color:#fff
  }
  .theme-wecan .blog-page .single_post .footer .stats li a:hover{
    color:#04b6f9
  }
  .theme-wecan .auth-main .btn-primary{
    background: #04b6f9
    ;border-color:#04b6f9
  }
  .theme-wecan .sidebar-nav .metismenu>li i{
    color:#04b6f9
  }
  .theme-wecan .right_chat li a:hover .media-object{
    border-color:#04b6f9
  }
  .theme-wecan .main_menu .navbar .navbar-nav .nav-item.active>a {
    color: #04b6f9;
  }

  .theme-wecan .card {
    background:;
    transition: .5s;
    border: 0;
    margin-bottom: 30px;
    border-radius: .55rem;
    position: relative;
    width: 100%;
    box-shadow: 0 1px 2px 0 #04b6f9;
  }
</style>

</head>

<body class="theme-wecan">


      @yield('content')
  <!-- end Account pages -->

  <!-- JAVASCRIPT -->
  <script src="{{ URL::asset('assets/auth/bundles/libscripts.bundle.js')}}"></script>
  <script src="{{ URL::asset('assets/auth/bundles/vendorscripts.bundle.js')}}"></script>
  <script src="{{ URL::asset('assets/auth/bundles/mainscripts.bundle.js')}}"></script>
  <script src="{{asset('assets/js/toastr/toastr.js')}}"></script>

  <script>
    $(function() {

      if ('{{$errors->has('username')}}') {
        var audio = new Audio("assets/audio/toast_sound.mp3");
        audio.play();
        toastr.options.timeOut = "10000";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-top-right';
        toastr['error']('{{ $errors->first('username') }}');
      }
      if ('{{session('status')}}') {
        var audio = new Audio("assets/audio/toast_sound.mp3");
        audio.play();
        toastr.options.timeOut = "10000";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-top-right';
        toastr['warning']('{{ session('status') }}');
      }
      $('.btn-toastr').on('click', function() {
        $context = $(this).data('context');
        $message = $(this).data('message');
        $position = $(this).data('position');
        if ($context === '') {
          $context = 'info';
        }
        if ($position === '') {
          $positionClass = 'toast-bottom-right';
        } else {
          $positionClass = 'toast-' + $position;
        }
        toastr.remove();
        toastr[$context]($message, '', {
          positionClass: $positionClass
        });
      });
    });
  </script>
  @section('js')

  @show
</body>

</html>
