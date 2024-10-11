@extends('master')

@section('tittle')
    Transaction Form
@endsection

@section('content')
    @if (session('transaction'))
        <h1>Confirm Information About Your Transaction Here</h1>
    @else
        <h1>Put Information About Your Transaction Here</h1>
    @endif

    <form method="POST" action="">
        @csrf

        @if(session('success'))  
            <div class="alert alert-success">  
                {{ session('success') }}  
            </div>  
        @endif  

        @if(session('failed'))  
            <div class="alert alert-danger">  
                {{ session('failed') }}  
            </div>  
        @endif

        <div class="mb-3">
            <label class="form-label">Receiver Account</label>

            @if (session('transaction'))
                <input value="{{ session('transaction.receiver_account') }}" name="receiver_account" type="number"
                    class="form-control">
            @else
                <input name="receiver_account" type="number" class="form-control">
            @endif

            @error('receiver_account')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>

            @if (session('transaction'))
                <input value="{{ session('transaction.amount') }}" name="amount" type="number" class="form-control">
            @else
                <input name="amount" type="number" class="form-control">
            @endif

            @error('amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{route('transaction.store')}}" class="btn btn-primary">Confirm</a>
        <a href="{{route('transaction.delete_headback')}}" class="btn btn-primary">Delete and Head back</a>
    </form>
@endsection
