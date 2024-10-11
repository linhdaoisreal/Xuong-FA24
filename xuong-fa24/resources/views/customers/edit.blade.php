@extends('master')

@section('tittle')
    Edit khách hàng {{ $customer->name }}
@endsection

@section('content')
    <div class="container">

        <h1>Edit KHACH HÀNG {{ $customer->name }}</h1>

        @if (session()->has('success') && !session()->get('success'))
            <div class="alert alert-primary" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif

        @if (session()->has('success') && session()->get('success'))
            <div class="alert alert-primary" role="alert">
                Success
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

        <form method="POST" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input value="{{ $customer->name }}" type="text" class="form-control" name="name" id="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-4 col-form-label">address</label>
                <div class="col-8">
                    <input value="{{ $customer->address }}" type="text" class="form-control" name="address" id="address" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-4 col-form-label">phone</label>
                <div class="col-8">
                    <input value="{{ $customer->phone }}" type="tel" class="form-control" name="phone" id="phone" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">email</label>
                <div class="col-8">
                    <input value="{{ $customer->email }}" type="email" class="form-control" name="email" id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">is_active</label>
                <div class="col-8">
                    <input type="checkbox" value="1" class="form-checkox" name="is_active" id="is_active" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="avarta" class="col-4 col-form-label">avarta</label>
                <div class="col-8">
                    <img src="{{ Storage::url($customer->avarta) }}" alt="" width="75px">
                    <input @checked($customer->is_active) type="file" class="form-control" name="avarta" id="avarta" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>
@endsection
