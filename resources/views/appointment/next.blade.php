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
                    <form action="{{ route('appointments.next.store', ['appointment' => $data->appointment->id]) }}"
                        method="post">
                        @csrf
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
                                <input type="hidden" name="patient_id" value="{{ $data->appointment->patient->id }}">
                            </div> <!-- form-group -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="branch_id">Branch</label>
                                <select onchange="changeBranch(this)" data-date-selector="new-sec-date"
                                    data-doctor-selector="new-sec-doctor" data-time-selector="new-sec-time" id="branch_id"
                                    name="branch_id" class="branchs form-control">
                                    <option data-doctors="{{ json_encode([]) }}" data-dates="{{ json_encode([]) }}"
                                        value="0">Select
                                        Branch</option>
                                    @foreach ($data->branches as $branch)
                                        <option data-dates="{{ json_encode($branch->schduleDates) }}"
                                            data-doctors="{{ json_encode($branch->doctors) }}"
                                            {{ old('branch_id') ?? $data->appointment->branch_id == $branch->id ? 'selected' : '' }}
                                            value="{{ $branch->id }}">{{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doctor_id">Dentist</label>
                                <select onchange="changeDoctor(this)" data-date-selector="new-sec-date"
                                    data-time-selector="new-sec-time" id="doctor_id" name="doctor_id"
                                    class="new-sec-doctor form-control">
                                </select>
                                @error('doctor_id')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="simple-select6">Date</label>
                                <select onchange="chageDate(this)" data-doctor-selector="new-sec-doctor"
                                    data-time-selector="new-sec-time" class="new-sec-date form-control select2"
                                    id="simple-select6" name="date_id">
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="simple-select8">Time</label>
                                <div id="new-div-time">
                                    <select class="new-sec-time form-control select2" id="simple-select8" name="time_id">
                                    </select>
                                </div>
                                <input name="urgent_time" id="new-time-inp" type="time" class="form-control d-none">
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Urgent</label>
                                </div>
                            </div>
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

@section('script')
    <script>
        let branch = "{{ $data->appointment->branch_id }}";
        let doctor = "{{ $data->appointment->doctor_id }}";
        let day = 0;
        let date = 0;

        function changeBranch(e) {
            let doctors = $(e).find("option:selected").data("doctors");
            let dates = $(e).find("option:selected").data("dates");
            let date_selector = $(e).data("date-selector");
            let doctor_selector = $(e).data("doctor-selector");
            let time_selector = $(e).data("time-selector");
            branch = $(e).val();

            let options = `<option value="0">Select Dentist</option>`;
            $.each(doctors, function(index, value) {
                options +=
                    `<option value="${value.id}" ${doctor == value.id?"selected":""}>${value.name}</option>`;
            });
            $("." + doctor_selector).html(options);

            options = `<option value="0" data-day-id="0">Select Date</option>`;
            $.each(dates, function(index, value) {
                options +=
                    `<option data-day-id="${value.schdule_day_id}" ${date == value.id?"selected":""} value="${value.id}">${value.dateFormated}</option>`;
            });
            $("." + date_selector).html(options);
            getTimes(time_selector);
        }

        changeBranch($("#branch_id"));

        function changeDoctor(e) {
            doctor = $(e).val();
            let date_selector = $(e).data("date-selector");
            let time_selector = $(e).data("time-selector");

            $.ajax({
                url: "/schdule-date-times/dates/" + branch + "/" + doctor,
                type: "GET",
                success: function(response) {
                    options = `<option value="0" data-day-id="0">Select Date</option>`;
                    $.each(response, function(index, value) {
                        options +=
                            `<option data-day-id="${value.schdule_day_id}" ${date == value.id?"selected":""} value="${value.id}">${value.dateFormated}</option>`;
                    });
                    $("." + date_selector).html(options);
                    getTimes(time_selector);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        changeDoctor($("#doctor_id"));

        function chageDate(e) {
            day = $(e).find("option:selected").data("day-id");
            let time_selector = $(e).data("time-selector");
            let doctor_selector = $(e).data("doctor-selector");
            date = $(e).val();

            $.ajax({
                url: "/schdule-date-times/doctors/" + branch + "/" + day,
                type: "GET",
                success: function(response) {
                    let options = `<option value="0">Select Dentist</option>`;
                    $.each(response, function(index, value) {
                        options +=
                            `<option value="${value.id}" ${doctor == value.id?"selected":""}>${value.name}</option>`;
                    });
                    $("." + doctor_selector).html(options);
                    getTimes(time_selector);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        function getTimes(time_selector) {
            $.ajax({
                url: "/schdule-date-times/times/" + branch + "/" + doctor + "/" + date,
                type: "GET",
                success: function(response) {
                    let options = `<option value="">Select Time</option>`;

                    $.each(response, function(index, value) {
                        options +=
                            `<option value="${value.id}">${value.timeFormated}</option>`;
                    });

                    $("." + time_selector).html(options);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        $('#customSwitch1').on('change', function() {
            if ($(this).is(':checked')) {
                $("#new-div-time").addClass("d-none");
                $("#new-time-inp").removeClass("d-none");
                $("#simple-select8").val("");
            } else {
                $("#new-time-inp").addClass("d-none");
                $("#new-div-time").removeClass("d-none");
            }
        });
    </script>
@endsection
