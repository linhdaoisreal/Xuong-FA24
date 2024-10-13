@extends('master')

@section('tittle')
    Reset password
@endsection

@section('content')
    <h1>Reset password</h1>

    @if ($errors->any())
            <div class="alert alert-primary" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
    
        <div>
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" >
        </div>
    
        <div>
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" >
        </div>
    
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" >
        </div>
    
        <button type="submit">Reset Password</button>
    
        @if (session('status'))
            <div>{{ session('status') }}</div>
        @endif
    </form>
@endsection
