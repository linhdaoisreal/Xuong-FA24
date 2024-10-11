@extends('master')

@section('tittle')
    Show Khách hàng {{ $customer->name }}
@endsection

@section('content')
    <h1>Show Khách hàng {{ $customer->name }}</h1>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Tên trường</th>
                    <th scope="col">GIá trị</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->toArray() as $key => $value)
                    <tr class="">
                        <td scope="row">{{ strtoupper($key) }}</td>
                        <td>
                            @php
                                switch ($key) {
                                    case 'avarta':
                                        if ($value) {
                                            $url = Storage::url($value);
                                            echo "<img src='$url' alt=' width='75px'>";
                                        }
                                        break;

                                    case 'is_active':
                                        echo $value
                                            ? '<span class="badge bg-info">YES!</span>'
                                            : '<span class="badge bg-danger">NO!</span>';
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
