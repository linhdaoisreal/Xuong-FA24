@extends('master')

@section('tittle')
    Danh sách khách hàng
@endsection

@section('content')
    <h1>Danh sách khách hàng</h1>

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-primary" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-primary" role="alert">
            Thao tac thanh cong
        </div>
    @endif

    <a class="btn btn-info" href="{{ route('customers.create') }}"> CREATE</a>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">IMAGE</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">IS ACTIVE</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $customer)
                    <tr class="">
                        <td scope="row">{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            @if ($customer->avarta)
                                <img src="{{ Storage::url($customer->avarta) }}" alt="" width="75px">
                            @endif
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            @if ($customer->is_active)
                                <span class="badge bg-primary">YES!</span>
                            @else
                                <span class="badge bg-danger">NO!</span>
                            @endif
                        </td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('customers.show', $customer) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('customers.edit', $customer) }}">Edit</a>

                            <form action="{{ route('customers.destroy', $customer) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Sure ???')" type="submit"
                                    class="btn btn-danger">DELETE</button>
                            </form>
                            <form action="{{ route('customers.forceDestroy', $customer) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Sure ???')" type="submit"
                                    class="btn btn-danger"> HARD DELETE</button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $data->links() }}
    </div>
@endsection
