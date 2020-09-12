@extends('errors::minimal')

@section('title', __('Server Error'))
@section('gambar')
<img src="{{asset('assets/images/server-down.png')}}" alt="" class="img-fluid" />
@endsection
@section('header', 'Opps, terjadi kesalahan')
@section('message')
Server Error 500. Mohon maaf dan kami sedang memperbaikinya.<br/> Silakan coba beberapa saat.
@endsection
