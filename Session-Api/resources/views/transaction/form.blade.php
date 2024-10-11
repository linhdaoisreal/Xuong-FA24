@extends('master')

@section('tittle')
    Transaction Form
@endsection

@section('content')
    
        <h1>Put Information About Your Transaction Here</h1>

    <form method="POST" action="{{ route('transaction.create') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Receiver Account</label>


                <input name="receiver_account" type="number" class="form-control">


            @error('receiver_account')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>


                <input name="amount" type="number" class="form-control">


            @error('amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
@endsection
