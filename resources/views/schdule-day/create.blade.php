@extends('layouts.main-layout')

@section('title', 'Schdule Pattern')

@section('page-path-prefix', 'SETTINGS > SCHEDULE > ')

@section('page-path', 'DAYS')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('schdule-days.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                    <form action="{{ route('schdule-days.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="simple-select2">Day</label>
                                <select class="form-control select2" id="simple-select2" name="day">
                                    <option {{ old('day') == 'saturday' ? 'selected' : '' }} value="saturday">Saturday
                                    </option>
                                    <option {{ old('day') == 'sunday' ? 'selected' : '' }} value="sunday">Sunday</option>
                                    <option {{ old('day') == 'monday' ? 'selected' : '' }} value="monday">Monday</option>
                                    <option {{ old('day') == 'tuesday' ? 'selected' : '' }} value="tuesday">Tuesday</option>
                                    <option {{ old('day') == 'wednesday' ? 'selected' : '' }} value="wednesday">Wednesday
                                    </option>
                                    <option {{ old('day') == 'thursday' ? 'selected' : '' }} value="thursday">Thursday
                                    </option>
                                    <option {{ old('day') == 'friday' ? 'selected' : '' }} value="friday">Friday</option>
                                </select>
                                @error('day')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div> <!-- form-group -->
                        </div>
                        <div id="appointments">
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label for="time">Time</label>
                                    <input type="time" class="form-control" value="{{ old('times.0.time') }}"
                                        name="times[0][time]">
                                    @error('times.0.time')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label for="doctor_id">Dentist</label>
                                    <select id="doctor_id" name="times[0][doctor_id]" class="form-control"
                                        {{ auth()->user()->is_doctor ? 'disabled' : '' }}>
                                        <option value="0">Select Dentist</option>
                                        @foreach ($doctors as $doctor)
                                            <option
                                                {{ auth()->user()->is_doctor && auth()->id() == $doctor->id ? 'selected' : '' }}
                                                {{ old('times.0.doctor_id') == $doctor->id ? 'selected' : '' }}
                                                value="{{ $doctor->id }}">{{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if (auth()->user()->is_doctor)
                                        <input type="hidden" value="{{ auth()->id() }}" name="times[0][doctor_id]">
                                    @endif
                                    @error('times.0.doctor_id')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label for="branch_id">Branch</label>
                                    <select id="branch_id" name="times[0][branch_id]" class="form-control">
                                        <option value="0">Select Branch</option>
                                        @foreach ($branchs as $branch)
                                            <option {{ old('times.0.branch_id') == $branch->id ? 'selected' : '' }}
                                                value="{{ $branch->id }}">{{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('times.0.branch_id')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <button type="button" id="add-appointment" class="btn btn-warning">Add Another
                                Appointment</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection

@section('script')
    <script>
        let index = 1;
        $(document).on("click", "#add-appointment", function() {
            var html =
                `
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="time">Time</label>
                        <input type="time" class="form-control" value="{{ old('times[${index}][time]') }}" name="times[${index}][time]">
                        @error('times[${index}][time]')
                            <p style="color: red">* {{ $message }}</p>
                        @enderror
                        <button type="button" class="mt-2 delete-time btn btn-danger btn-sm">Delete</button>
                    </div>
<div class="form-group col-4">
                                    <label for="doctor_id">Dentist</label>
                                    <select id="doctor_id" name="times[${index}][doctor_id]" class="form-control" {{ auth()->user()->is_doctor ? 'disabled' : '' }}>
                                            <option value="0">Select Dentist</option>
                                        @foreach ($doctors as $doctor)
                                            <option {{ auth()->user()->is_doctor && auth()->id() == $doctor->id ? 'selected' : '' }}
                                                value="{{ $doctor->id }}">{{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                     @if (auth()->user()->is_doctor)
                                            <input type="hidden" value="{{ auth()->id() }}"
                                                name="times[${index}][doctor_id]">
                                        @endif
                                    @error('times[${index}][doctor_id]')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label for="branch_id">Branch</label>
                                    <select id="branch_id" name="times[${index}][branch_id]" class="form-control">
                                            <option value="0">Select Branch</option>
                                        @foreach ($branchs as $branch)
                                            <option {{ old('times[${index}][branch_id]') == $branch->id ? 'selected' : '' }}
                                                value="{{ $branch->id }}">{{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('times[${index}][branch_id]')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                </div>
                `;
            $("#appointments").append(html);
            index++;
        })

        $(document).on('click', ".delete-time", function() {
            $(this).closest('.form-row').remove();
        })
    </script>

@endsection
