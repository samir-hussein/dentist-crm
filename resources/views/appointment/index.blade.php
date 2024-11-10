@extends('layouts.main-layout')

@section('title', 'Appointment List')

@section('buttons')
    <a href="{{ route('appointments.create') }}">
        <button type="button" class="btn btn-primary">
            <span class="fe fe-plus fe-12 mr-2"></span>Create
        </button>
    </a>
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
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>Visit No.</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Patient Phone 2</th>
                                <th>Doctor Name</th>
                                <th>Services</th>
                                <th>Appointment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $appointment)
                                <tr>
                                    <td># {{ $appointment->visit_no }}</td>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->patient->phone }}</td>
                                    <td>{{ $appointment->patient->phone2 }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->selectedServices }}</td>
                                    <td>{{ $appointment->formatedTime }}</td>
                                    <td>
                                        <a class="btn mb-1 btn-sm btn-info"
                                            href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}">Edit</a>

                                        @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                                            <a href="{{ route('appointments.markCompleted', ['appointment' => $appointment->id]) }}"
                                                class="btn mb-1 btn-sm btn-success">Completed</a>
                                        @endif

                                        <a href="{{ route('patients.profile', ['patient' => $appointment->patient->id]) }}"
                                            class="btn mb-1 btn-sm btn-warning">Patient File</a>

                                        <form class="d-inline mb-1" method="POST"
                                            action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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
        $('#dataTable-1').DataTable({
            order: []
        });
    </script>
@endsection
