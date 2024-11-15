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
            @if ($data->appointment->patient->labOrder)
                <div class="alert alert-danger" role="alert">
                    There is lab work for this pateint in lab {{ $data->appointment->patient->labOrder->lab->name }} sent at
                    {{ $data->appointment->patient->labOrder->sent?->format('d-m-Y') }} received at
                    {{ $data->appointment->patient->labOrder->received?->format('d-m-Y') ?? '' }}
                </div>
            @endif
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
                <div class="card-body">
                    <form action="{{ route('appointments.update', ['appointment' => $data->appointment->id]) }}"
                        method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="simple-select2">Patient</label>
                                <select class="form-control select2" id="simple-select2" name="patient_id" disabled>
                                    @foreach ($data->patients as $patient)
                                        <option {{ $data->appointment->patient->id == $patient->id ? 'selected' : '' }}
                                            value="{{ $patient->id }}">#{{ $patient->code }} |
                                            {{ $patient->name }} |
                                            {{ $patient->phone }} | {{ $patient->phone2 }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> <!-- form-group -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="doctor_id">Dentist</label>
                                <select id="doctor_id" name="doctor_id" class="form-control">
                                    @foreach ($data->doctors as $doctor)
                                        <option
                                            {{ old('doctor_id') ?? $data->appointment->doctor->id == $doctor->id ? 'selected' : '' }}
                                            value="{{ $doctor->id }}">{{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="simple-select4">Appointment</label>
                                <select class="form-control select2" id="simple-select4" name="time_id">
                                    @foreach ($data->times as $time)
                                        <option
                                            {{ old('time_id') ?? $data->appointment->time_id == $time->id ? 'selected' : '' }}
                                            value="{{ $time->id }}">
                                            {{ $time->manually_updated_time?->format('l d-m-Y h:i a') ?? $time->time->format('l d-m-Y h:i a') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="multi-select2" class="d-block">Services</label>
                                <select multiple name="service_ids[]" class="form-control select2-multi d-block w-100"
                                    id="multi-select2">
                                    @foreach ($data->services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ in_array($service->id, $data->appointment->selected_services) ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="branch_id">Branch</label>
                                <select id="branch_id" name="branch_id" class="form-control">
                                    @foreach ($data->branches as $branch)
                                        <option
                                            {{ old('branch_id') ?? $data->appointment->branch?->id == $branch?->id ? 'selected' : '' }}
                                            value="{{ $branch?->id }}">{{ $branch?->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="notes">Notes</label>
                                <textarea name="notes" class="form-control" id="" cols="30" rows="5">{{ old('notes') ?? $data->appointment->notes }}</textarea>
                                @error('notes')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection
