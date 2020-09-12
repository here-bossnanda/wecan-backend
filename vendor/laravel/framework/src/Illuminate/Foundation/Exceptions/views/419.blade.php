@extends('errors::minimal')

@section('title', __('419 | Page Expired'))
@section('gambar')
<img src="{{asset('assets/images/coming-soon.png')}}" alt="" class="img-fluid" />
@endsection
@section('header', '419 | page expired')
@section('message')
Page Expired. Mohon maaf halaman anda telah expired.<br/> Silakan coba beberapa saat.
@endsection

