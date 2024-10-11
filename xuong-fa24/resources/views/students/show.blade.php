@extends('master')

@section('tittle')
    Show Nhân viên {{ $student->name }}
@endsection

@section('content')
    <h1>Show Nhân viên {{ $student->name }}</h1>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Tên trường</th>
                    <th scope="col">GIá trị</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->toArray() as $key => $value)
                    <tr class="">
                        <td scope="row">{{ strtoupper($key) }}</td>
                        <td>
                            @switch($key)
                                @case('classroom')
                                    <p>{{ $student->classroom ? $student->classroom->name : 'Không có lớp' }}</p>
                                @break

                                @case('passport')
                                    <p>{{ $student->passport ? $student->passport->passport_number : 'Không có số hộ chiếu' }}</p>
                                @break

                                @case('subjects')
                                    <p>{{ $student->subjects ?? 'Không có Môn nào được đăng kí' }}</p>

                                    <a href="">Register for New Subjects</a>
                                @break

                                @case('created_at')
                                    <p>{{ \Carbon\Carbon::parse($student->created_at)->format('d/m/Y') }}</p>
                                @break

                                @case('updated_at')
                                    <p>{{ \Carbon\Carbon::parse($student->updated_at)->format('d/m/Y') }}</p>
                                @break

                                @default
                                    <p>{{ $value }}</p>
                            @endswitch
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
