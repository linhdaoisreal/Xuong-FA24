@extends('master')

@section('tittle')
    Edit khách hàng {{ $employee->name }}
@endsection

@section('content')
    <div class="container">

        <h1>Edit KHACH HÀNG {{ $employee->name }}</h1>

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

        <form method="POST" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">First Name</label>
                <div class="col-8">
                    <input value="{{ $employee->first_name }}" type="text" class="form-control" name="first_name"
                        id="first_name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">Last Name</label>
                <div class="col-8">
                    <input value="{{ $employee->last_name }}" type="text" class="form-control" name="last_name"
                        id="last_name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">email</label>
                <div class="col-8">
                    <input value="{{ $employee->email }}" type="email" class="form-control" name="email"
                        id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-4 col-form-label">phone</label>
                <div class="col-8">
                    <input value="{{ $employee->phone }}" type="tel" class="form-control" name="phone"
                        id="phone" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="date_of_birth" class="col-4 col-form-label">date_of_birth</label>
                <div class="col-8">
                    <input value="{{ $employee->date_of_birth }}" type="date" class="form-control" name="date_of_birth"
                        id="date_of_birth" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="hire_date" class="col-4 col-form-label">hire_date</label>
                <div class="col-8">
                    <input value="{{ $employee->hire_date }}" type="datetime-local" class="form-control" name="hire_date"
                        id="hire_date" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="salary" class="col-4 col-form-label">salary</label>
                <div class="col-8">
                    <input value="{{ $employee->salary }}" type="number" class="form-control" name="salary"
                        id="salary" />
                </div>
            </div>


            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">is_active</label>
                <div class="col-8">
                    <input type="checkbox" value="1" class="form-checkox" name="is_active" id="is_active" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">department_id</label>
                <div class="col-8">
                    <select class="form-select" name="department_id" id="">
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}" @selected($employee->department_id == $d->id)>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">manager_id</label>
                <div class="col-8">
                    <select class="form-select" name="manager_id" id="">
                        @foreach ($managers as $m)
                            <option value="{{ $m->id }}" @selected($employee->manager_id == $m->id)>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-4 col-form-label">address</label>
                <div class="col-8">
                    <input value="{{ $employee->address }}" type="text" class="form-control" name="address"
                        id="address" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="profile_picture" class="col-4 col-form-label">profile_picture</label>
                <div class="col-8">
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" />
                    @php
                        $binaryData = $employee->profile_picture;

                        $base64String = base64_encode($binaryData);
                        $pictureSrc = 'data:image/jpeg/jpg/png;base64, ' . $base64String;
                    @endphp
                    <img src="{{ $pictureSrc }}" alt="" width="100px">
                </div>

            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>
@endsection
