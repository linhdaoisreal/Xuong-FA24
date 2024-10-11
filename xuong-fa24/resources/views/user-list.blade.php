@extends('master')

@section('tittle')
    User List
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">USER ID</th>
                    <th scope="col">PHONE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr class="">
                        <td>{{$user->id}}</td>
                        <td>{{$user->phone->value}}</td>
                    </tr>
                @endforeach
                
                
            </tbody>
        </table>
    </div>

    {{$data->links()}}
@endsection
