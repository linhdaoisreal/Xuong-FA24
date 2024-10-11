@extends('master')

@section('tittle')
    Transaction
@endsection

@section('content')
    <h1>Transaction</h1>

    @if(session('success'))  
        <div class="alert alert-success">  
            {{ session('success') }}  
        </div>  
    @endif  

    <a href="{{route('transaction.form')}}">Create New Transaction</a>
@endsection