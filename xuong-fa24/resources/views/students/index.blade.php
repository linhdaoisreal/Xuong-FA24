@extends('master')

@section('tittle')
    Danh sách Student
@endsection

@section('content')
    <h1>Danh sách Student</h1>

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-primary" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-primary" role="alert">
            Thao tac thanh cong
        </div>
    @endif

    <a class="btn btn-info" href="{{ route('students.create') }}"> CREATE</a>

    <div class="table-container">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">CLASSROOM</th>
                    <th scope="col">PASSPORT</th>
                    <th scope="col">TEACHER</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $student)
                    <tr class="">
                        <td scope="row">{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->classroom->name }}</td>
                        <td>
                            @if ($student->passport)
                                {{$student->passport->passport_number}}
                            @else
                                <a class="btn btn-info" href="{{ route('students.addPassport', $student ) }}">Add passport</a>
                            @endif
                        </td>
                        <td>{{ $student->classroom->teacher_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->created_at)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->updated_at)->format('d/m/Y') }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('students.show', $student) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('students.edit', $student) }}">Edit</a>

                            <form action="{{ route('students.destroy', $student) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Sure ???')" type="submit"
                                    class="btn btn-danger">DELETE</button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $data->links() }}
    </div>
@endsection
