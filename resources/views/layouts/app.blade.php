<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>ADMIN | WECAN - Week of Creativity and Innovation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="WECAN - Week of Creativity and Innovation" name="description" />
  <meta content="@bossnanda & apex" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">
  
  @include('layouts.parts.head-script')

</head>

<body data-topbar="colored">
  <!-- Begin page -->
  <div id="layout-wrapper">
    @include('layouts.parts.header')
    @include('layouts.parts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

      <div class="page-content">
        @yield('content')

        @include('layouts.parts.footer')

      </div>
      <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
@include('layouts.parts.footer-script')

</body>
</html>
