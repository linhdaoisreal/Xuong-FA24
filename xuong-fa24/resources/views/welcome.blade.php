@extends('master')

@section('content')
    @if (session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif


    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-primary" role="alert">
            Dang nhap thanh cong
        </div>
    @endif
@endsection
