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
                                    @if ($student->passport)
                                        <p class="fw-bold">Passport Number: <span class="fw-normal">{{$student->passport->passport_number}}</span></p>
                                        <p class="fw-bold">Issued Date: <span class="fw-normal">{{$student->passport->issued_date}}</span></p>
                                        <p class="fw-bold">Expiry Date: <span class="fw-normal">{{$student->passport->expiry_date}}</span></p>
                                    @else
                                        <p>Không có số hộ chiếu</p>
                                        <a class="btn btn-info" href="{{ route('students.addPassport', $student ) }}">Add passport</a>
                                    @endif
                                @break

                                @case('subjects')
                                    <h4>Danh sách môn học</h4>
                                    @if ($student->subjects != '')
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Subject Name</th>
                                                    <th>Credit</th>
                                                    <th>Register Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($student->subjects as $subject)  
                                                <tr>  
                                                    <td>{{ $subject->name }}</td>
                                                    <td>{{ $subject->credits }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($subject->created_at)->format('d/m/Y') }}</td> 
                                                </tr>  
                                                @endforeach 
                                            </tbody>
                                             
                                        </table>
                                    @endif

                                    <a class="btn btn-info" href="{{ route('students.addSubjects', $student ) }}">Register for New Subjects</a>
                                    <a class="btn btn-danger" href="{{ route('students.unsubmitSubjects', $student ) }}">Unsubmit Subjects</a>
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
