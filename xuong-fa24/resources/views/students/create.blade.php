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

        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input value="{{ old('email') }}" type="email" class="form-control" name="email" id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">Classroom</label>
                <div class="col-8">
                    <select class="form-select" name="classroom_id" id="">
                        <option value="">Choose Your Class Wisely</option>
                        @foreach ($classrooms as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>

        </form>
    </div>
@endsection
