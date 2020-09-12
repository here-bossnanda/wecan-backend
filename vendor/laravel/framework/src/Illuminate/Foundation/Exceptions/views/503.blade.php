@extends('errors::minimal')

@section('title', __('503 | Service Unavailable'))
@section('gambar')
<img src="{{asset('assets/images/server-down.png')}}" alt="" class="img-fluid" />
@endsection
@section('header', '503 | Maintance')
@section('message')
{{__($exception->getMessage() ?: 'Service Unavailable')}}
@endsection
