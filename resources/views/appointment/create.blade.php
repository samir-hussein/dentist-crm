@extends('layouts.main-layout')

@section('title', 'Appointment List')

@section('style')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('appointments.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">New Patient</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Old Patient</a>
                            </li>
                        </ul>
                        <div class="tab-content mb-1" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('appointments.store') }}" method="post">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="{{ old('name') }}" name="name" dir="auto">
                                                    @error('name')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        value="{{ old('phone') }}" name="phone">
                                                    @error('phone')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="date_of_birth">Date Of Birth</label>
                                                    <input type="date" class="form-control" id="date_of_birth"
                                                        value="{{ old('date_of_birth') }}" name="date_of_birth">
                                                    @error('date_of_birth')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                    @error('gender')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="doctor_id">Doctor</label>
                                                    <select id="doctor_id" name="doctor_id" class="form-control">
                                                        @foreach ($data->doctors as $doctor)
                                                            <option {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                                                value="{{ $doctor->id }}">{{ $doctor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('doctor_id')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="date">Appointment Date</label>
                                                    <input type="date" class="form-control" id="date"
                                                        value="{{ old('date') }}" name="date">
                                                    @error('date')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="time">Appointment Time</label>
                                                    <input type="time" class="form-control" id="time"
                                                        value="{{ old('time') }}" name="time">
                                                    @error('time')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="multi-select">Services</label>
                                                    <select multiple name="service_ids[]"
                                                        class="form-control select2-multi" id="multi-select">
                                                        @foreach ($data->services as $service)
                                                            <option value="{{ $service->id }}">{{ $service->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('service_ids')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="notes">Notes</label>
                                                    <textarea name="notes" class="form-control" id="" cols="30" rows="5">{{ old('notes') }}</textarea>
                                                    @error('notes')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('appointments.store') }}" method="post">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="simple-select2">Patient</label>
                                                    <select class="form-control select2" id="simple-select2"
                                                        name="patient_id">
                                                        @foreach ($data->patients as $patient)
                                                            <option
                                                                {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                                                value="{{ $patient->id }}">{{ $patient->name }} -
                                                                {{ $patient->phone }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> <!-- form-group -->
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="doctor_id">Doctor</label>
                                                    <select id="doctor_id" name="doctor_id" class="form-control">
                                                        @foreach ($data->doctors as $doctor)
                                                            <option {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                                                value="{{ $doctor->id }}">{{ $doctor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('doctor_id')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="date">Appointment Date</label>
                                                    <input type="date" class="form-control" id="date"
                                                        value="{{ old('date') }}" name="date">
                                                    @error('date')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="time">Appointment Time</label>
                                                    <input type="time" class="form-control" id="time"
                                                        value="{{ old('time') }}" name="time">
                                                    @error('time')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="multi-select2" class="d-block">Services</label>
                                                    <select multiple name="service_ids[]"
                                                        class="form-control select2-multi d-block w-100"
                                                        id="multi-select2">
                                                        @foreach ($data->services as $service)
                                                            <option value="{{ $service->id }}">{{ $service->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="notes">Notes</label>
                                                    <textarea name="notes" class="form-control" id="" cols="30" rows="5">{{ old('notes') }}</textarea>
                                                    @error('notes')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /. col -->
    </div>
@endsection
