@extends('master')

@section('tittle')
    Edit Student {{ $student->name }}
@endsection

@section('content')
    <div class="container">

        <h1>Edit STUDENT {{ $student->name }}</h1>

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

        <form method="POST" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input value="{{ $student->name }}" type="text" class="form-control" name="name"
                        id="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input value="{{ $student->email }}" type="email" class="form-control" name="email"
                        id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">Classroom_id</label>
                <div class="col-8">
                    <select class="form-select" name="classroom_id" id="">
                        @foreach ($classrooms as $d)
                            <option value="{{ $d->id }}" @selected($student->classroom_id == $d->id)>{{ $d->name }}</option>
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
