@extends('master')

@section('tittle')
    Register
@endsection

@section('content')
    <h1>Register</h1>

    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-primary" role="alert">
            Tao tai khoan thanh cong
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-primary" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('registerConfirm')}}">
        @csrf

        <!-- Name input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="text" id="form2Example1" class="form-control" name="name" value="{{old('name')}}"/>
            <label class="form-label" for="form2Example1">Name</label>
        </div>

        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form2Example1" class="form-control" name="email" value="{{old('email')}}"/>
            <label class="form-label" for="form2Example1">Email address</label>
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="form2Example2" class="form-control" name="password" />
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="form2Example2" class="form-control" name="password_confirmation" />
            <label class="form-label" for="form2Example2">Password Confirm</label>
        </div>

        <!-- Submit button -->
        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
            Register
        </button>
    </form>
@endsection
