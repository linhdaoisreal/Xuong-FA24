@extends('master')

@section('tittle')
    Forgot password
@endsection

@section('content')
    <h1>Forgot password</h1>

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div>
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>
        </div>
    
        <button type="submit">Send Password Reset Link</button>
    
        @if (session('status'))
            <div>{{ session('status') }}</div>
        @endif
    </form>
@endsection
