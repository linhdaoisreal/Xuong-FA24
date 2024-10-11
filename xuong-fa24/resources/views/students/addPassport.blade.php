@extends('master')

@section('tittle')
    Add new Student
@endsection

@section('content')
    <div class="container">

        <h1>THÊM MỚI STUDENT</h1>

        @if (session()->has('success') && !session()->get())
            <div class="alert alert-primary" role="alert">
                {{ session()->get('error') }}
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

        <form method="POST" action="{{ route('students.storePassport') }}" enctype="multipart/form-data">
            @csrf

            <input value="{{ $student->id }}" type="hidden" class="form-control" name="student_id" id="student_id" />

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">passport_number</label>
                <div class="col-8">
                    <input value="{{ old('passport_number') }}" type="number" class="form-control" name="passport_number" id="passport_number" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">issued_date</label>
                <div class="col-8">
                    <input value="{{ old('issued_date') }}" type="date" class="form-control" name="issued_date" id="issued_date" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">expiry_date</label>
                <div class="col-8">
                    <input value="{{ old('expiry_date') }}" type="date" class="form-control" name="expiry_date" id="expiry_date" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>

        </form>
    </div>
@endsection
