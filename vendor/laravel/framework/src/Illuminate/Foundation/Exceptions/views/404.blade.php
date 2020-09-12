@extends('errors::minimal')

@section('title', __('404 | Halaman Tidak ditemukan'))
@section('gambar')
<img src="{{asset('assets/images/error-img.png')}}" alt="" class="img-fluid mx-auto d-block">
@endsection
@section('header', '404 | Sorry, Page not Found')
@section('message')
Halaman tidak ditemukan. <br/> kamu mungkin mengetikan alamat yang salah atau halaman tidak ada.
@endsection