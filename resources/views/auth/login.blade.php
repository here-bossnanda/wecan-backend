@extends('layouts.auth.app')
@section('title')
<title>
  TIMDP - LOGIN</title>
  @endsection
  @section('content')

  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <div class="loader">
      <div class="m-t-30"><img src="{{URL::asset('assets/images/logo.png')}}" width="10%"  alt="WECAN"></div>
      <p>Please wait...</p>
    </div>
  </div>

  <!-- WRAPPER -->
  <div id="wrapper">
    <div class="vertical-align-wrap">
      <div class="vertical-align-middle auth-main ">
        <div class="auth-box">
          <div class="top">
            {{-- <h1 style="color:white">WECAN</h1> --}}
          </div>
          <div class="card">
            
            <div class="header">
                <h1 class=" text-center">BAPAKMU</h1>
                {{-- <img style="width:300px;" class="align-center" src="{{URL::asset('assets/images/logo.png')}}" alt="WECAN"> --}}
                <p class="lead text-center" >Login to your account</p>

            </div>
            <div class="body" >
              <form class="form-auth-small" method="POST" id="#ajax-inquire" action="{{ route('login') }}">
                @csrf
                <div class="form-group{{$errors->has('username') ? ' has-error' : '' }}">
                  <label for="username" class="control-label sr-only">username</label>
                  <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                </div>
                <div class="form-group{{$errors->has('password') ? ' has-error' : '' }}">
                  <label for="password" class="control-label sr-only">Password</label>
                  <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
                  @if ($errors->has('password'))
                  <span class="help-block">
                    <strong class="badge-danger">{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block btn-toastr">LOGIN</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END WRAPPER -->
  @endsection
