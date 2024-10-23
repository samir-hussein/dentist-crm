@extends('layouts.main-layout')

@section('title', 'Schdule Dates')

@section('page-path-prefix', 'SETTINGS >> SCHDULE SETTINGS >> ')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('schdule-dates.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
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
    <div class="row my-4">
        <!-- Small table -->
        <div class="col-md-12">
            <h4>{{ $data->schduleDay->day }} - {{ $data->date->format('Y-m-d') }}</h4>
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Patient Phone2</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->appointments as $appointment)
                                <tr>
                                    <td>
                                        <form action="{{ route('times.update', ['time' => $appointment->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('put')
                                            <input type="time" class="form-control"
                                                value="{{ $appointment->manually_updated_time ? \Carbon\Carbon::parse($appointment->manually_updated_time)->format('H:i') : \Carbon\Carbon::parse($appointment->time)->format('H:i') }}"
                                                name="time">
                                            <button id="time{{ $appointment->id }}" type="submit" hidden
                                                class="btn btn-primary btn-sm">Save</button>
                                        </form>
                                    </td>
                                    <td>{{ $data->patient?->name }}</td>
                                    <td>{{ $data->patient?->phone }}</td>
                                    <td>{{ $data->patient?->phone2 }}</td>
                                    <td>
                                        <button data-id="time{{ $appointment->id }}"
                                            data-url="{{ route('times.update', ['time' => $appointment->id]) }}"
                                            class="update-time btn btn-primary btn-sm">
                                            <span class="fe fe-edit fe-12 mr-2"></span> Save Updated Time
                                        </button>
                                        <form class="d-inline"
                                            action="{{ route('times.destroy', ['time' => $appointment->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <span class="fe fe-trash-2 fe-12 mr-2"></span> Delete
                                            </button>
                                        </form>
                                    </td>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection

@section('script')
    <script>
        $(document).on("click", ".update-time", function() {
            var id = $(this).data("id");
            $("#" + id).click();
        })
    </script>
@endsection
