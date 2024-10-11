@extends('master')

@section('tittle')
    Danh sách Nhân viên
@endsection

@section('content')
    <h1>Danh sách Nhân viên</h1>

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

    <a class="btn btn-info" href="{{ route('employees.create') }}"> CREATE</a>

    <div class="table-container">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">PROFILE PICTURE</th>
                    <th scope="col">BIRTHDAY</th>
                    <th scope="col">HIRE DATE</th>
                    <th scope="col">SALARY</th>
                    <th scope="col">DEPARTMENT</th>
                    <th scope="col">MANAGER</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">IS ACTIVE</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $employee)
                    <tr class="">
                        <td scope="row">{{ $employee->id }}</td>
                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td>{{ $employee->address }}</td>
                        <td>
                            @if ($employee->profile_picture) 
                                @php
                                    $binaryData = $employee->profile_picture;

                                    $base64String = base64_encode($binaryData);
                                    $pictureSrc = 'data:image/jpeg/jpg/png;base64, ' . $base64String;
                                @endphp
                                <img src="{{$pictureSrc}}" alt="" width="75px">
                            @endif

                        </td>
                        <td>{{ $employee->date_of_birth }}</td>
                        <td>{{ $employee->hire_date }}</td>
                        <td>{{ $employee->salary }}</td>
                        <td>
                            @foreach ($departments as $d)
                                @if ($d->id == $employee->department_id)
                                    {{$d->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($managers as $m)
                                @if ($m->id == $employee->manager_id)
                                    {{$m->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            @if ($employee->is_active)
                                <span class="badge bg-primary">YES!</span>
                            @else
                                <span class="badge bg-danger">NO!</span>
                            @endif
                        </td>
                        <td>{{ $employee->created_at }}</td>
                        <td>{{ $employee->updated_at }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('employees.show', $employee) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('employees.edit', $employee) }}">Edit</a>

                            <form action="{{ route('employees.destroy', $employee) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Sure ???')" type="submit"
                                    class="btn btn-danger">DELETE</button>
                            </form>
                            <form action="{{ route('employees.forceDestroy', $employee) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Sure ???')" type="submit" class="btn btn-danger"> HARD
                                    DELETE</button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $data->links() }}
    </div>
@endsection
