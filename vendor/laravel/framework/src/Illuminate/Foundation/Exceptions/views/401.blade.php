@extends('errors::minimal')

@section('title', __('401 | Unauthorized'))
@section('gambar')
<img src="{{asset('assets/images/not-found.png')}}" alt="" class="img-fluid mx-auto d-block">
@endsection
@section('header', '401 | Unauthorized')
@section('message')
Aksi tidak sah. <br/> kamu tidak memiliki hak akses untuk melakukan aksi ini.
@endsection
