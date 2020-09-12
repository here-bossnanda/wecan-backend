@extends('errors::minimal')

@section('title', __('403 | Forbidden'))
@section('gambar')
<img src="{{asset('assets/images/not-found.png')}}" alt="" class="img-fluid mx-auto d-block">
@endsection
@section('header', '403 | Forbidden')
@section('message',__($exception->getMessage() ?: 'Forbidden'))
