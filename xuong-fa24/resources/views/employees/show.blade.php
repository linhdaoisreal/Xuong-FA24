@extends('master')

@section('tittle')
    Show Nhân viên {{ $employee->name }}
@endsection

@section('content')
    <h1>Show Nhân viên {{ $employee->name }}</h1>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Tên trường</th>
                    <th scope="col">GIá trị</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee->toArray() as $key => $value)
                    <tr class="">
                        <td scope="row">{{ strtoupper($key) }}</td>
                        <td>
                            @php
                                switch ($key) {
                                    case 'profile_picture':
                                        if ($value) {
                                            $binaryData = $value;

                                            $base64String = base64_encode($binaryData);
                                            $pictureSrc = 'data:image/jpeg/jpg/png;base64, ' . $base64String;
                                            echo "<img src='$pictureSrc' alt=' width='50%'>";
                                        }
                                        break;

                                    case 'is_active':
                                        echo $value
                                            ? '<span class="badge bg-info">YES!</span>'
                                            : '<span class="badge bg-danger">NO!</span>';
                                        break;

                                    case 'department_id':
                                        foreach ($departments as $d) {
                                            if ($value == $d['id']) {
                                                echo $d['name'];
                                            }
                                        }
                                        break;

                                    case 'manager_id':
                                        foreach ($managers as $m) {
                                            if ($value == $m['id']) {
                                                echo $d['name'];
                                            }
                                        }
                                        break;

                                    default:
                                        echo $value;
                                        break;
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
