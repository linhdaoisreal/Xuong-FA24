@extends('master')

@section('tittle')
    Register New Subject
@endsection

@section('content')
    <div class="container">

        <h1>Register New Subject</h1>

        @if (session()->has('success') && !session()->get('success'))
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

        <form action="{{ route('students.storeSubjects', $student) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="subjects">Chọn môn học:</label>
                @foreach ($subjects as $subject)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                            id="subject{{ $subject->id }}"
                            {{ $student->subjects->contains($subject->id) ? 'disabled' : '' }}>
                        <label class="form-check-label" for="subject{{ $subject->id }}">
                            {{ $subject->name }}
                        </label>
                    </div>
                @endforeach
                @error('subjects')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
            <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">Head Back</a>
        </form>
    </div>
@endsection
