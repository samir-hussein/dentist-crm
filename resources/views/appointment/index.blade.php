@extends('layouts.main-layout')

@section('title', 'Appointment List')

@section('buttons')
    <a href="{{ route('appointments.create') }}">
        <button type="button" class="btn btn-primary">
            <span class="fe fe-plus fe-12 mr-2"></span>Add
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
            <div class="form-row">
                <div class="form-group col-12 col-md-4">
                    <label for="reportrange">Filter By Date : </label>
                    <div id="reportrange" class="border px-2 py-2 bg-light">
                        <i class="fe fe-calendar fe-16 mx-2"></i>
                        <span id="date-range"></span>
                    </div>
                </div>

                @if (!auth()->user()->is_doctor)
                    <div class="form-group col-6 col-md-4">
                        <label for="doctor_id">Filter By Dentist : </label>
                        <select id="doctor_id" name="doctor_id" class="form-control">
                            <option value="0">All Dentists</option>
                            @foreach ($doctors as $doctor)
                                <option {{ request('doctor') == $doctor->id ? 'selected' : '' }}
                                    value="{{ $doctor->id }}">
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="form-group col-6 col-md-4">
                    <label for="branch_id">Filter By Branch : </label>
                    <select id="branch_id" name="branch_id" class="form-control">
                        <option value="0">All Branches</option>
                        @foreach ($branches as $branch)
                            <option {{ request('branch') == $branch->id ? 'selected' : '' }} value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>Patient Id</th>
                                <th>Patient Name</th>
                                <th>Patient Phone</th>
                                <th>Patient Phone 2</th>
                                <th>Branch</th>
                                <th>Dentist</th>
                                <th>Services</th>
                                <th>Appointment</th>
                                <th>Notes</th>
                                <th>Lab Orders</th>
                                <th>Last Seen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->code }}</td>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->patient->phone }}</td>
                                    <td>{{ $appointment->patient->phone2 }}</td>
                                    <td>{{ $appointment->branch?->name }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->selectedServices }}</td>
                                    <td>{{ $appointment->formatedTime }}</td>
                                    <td>{{ $appointment->notes }}</td>
                                    <td><span
                                            class="badge badge-info">{{ $appointment->patient->labOrder ? 'sent to lab ' . $appointment->patient->labOrder->lab->name . ' at ' . $appointment->patient->labOrder->sent?->format('d-m-Y') . ' received at ' . $appointment->patient->labOrder->received?->format('d-m-Y') : 'No Orders' }}</span>
                                    </td>
                                    <td><span
                                            class="badge badge-danger">{{ $appointment->patient->latestTreatmentSession?->updated_at->format('Y-m-d') ?? 'No Appointments Were Found' }}</span>
                                    </td>
                                    <td>
                                        @if ($appointment->completed)
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <a class="btn mb-1 btn-sm btn-info"
                                                href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}">Edit</a>

                                            <a class="btn mb-1 btn-sm btn-dark" style="font-size: 10px"
                                                href="{{ route('appointments.next', ['appointment' => $appointment->id]) }}">Next
                                                Appointment</a>

                                            @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                                                <a href="{{ route('appointments.markCompleted', ['appointment' => $appointment->id]) }}"
                                                    class="btn mb-1 btn-sm btn-success">Completed</a>

                                                <a href="{{ route('patients.file', ['patient' => $appointment->patient->id]) }}"
                                                    class="btn mb-1 btn-sm btn-warning">Patient File</a>
                                            @endif

                                            <form class="d-inline mb-1" method="POST"
                                                action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
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

        // Get 'from' and 'to' from the URL query parameters
        var urlParams = new URLSearchParams(window.location.search);
        var fromDate = urlParams.get('from'); // Get 'from' timestamp from URL
        var toDate = urlParams.get('to'); // Get 'to' timestamp from URL

        // If 'from' and 'to' are present, use them as Unix timestamps (milliseconds), else default to the current date
        var start = fromDate ? moment(parseInt(fromDate)) : moment(); // Convert 'from' timestamp to moment object
        var end = toDate ? moment(parseInt(toDate)) : moment(); // Convert 'to' timestamp to moment object

        // Callback function to display selected range
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        // Initialize date range picker
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')], // Tomorrow
                'Next 7 Days': [moment(), moment().add(7, 'days')], // 7 days in the future
                'Next 30 Days': [moment(), moment().add(30, 'days')], // 30 days in the future
                'This Month': [moment().startOf('month'), moment().endOf(
                    'month')], // This Month (next)
                'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf(
                    'month')] // Next Month
            }
        }, cb);

        // Call cb to set the initial selected date range text
        cb(start, end);

        // Listen for date range selection
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            // Get the selected start and end dates
            var selectedStart = picker.startDate.format('YYYY-MM-DD');
            var selectedEnd = picker.endDate.format('YYYY-MM-DD');

            // Convert formatted date to timestamp in milliseconds
            start = new Date(selectedStart).getTime();
            end = new Date(selectedEnd).getTime();

            window.location.href = "{{ route('appointments.index') }}?from=" + start + "&to=" + end + "&doctor=" +
                $("#doctor_id").val() + "&branch=" + $("#branch_id").val();
        });

        $("#doctor_id").change(function() {
            window.location.href = "{{ route('appointments.index') }}?from=" + start + "&to=" + end + "&doctor=" +
                $(this).val() + "&branch=" + $("#branch_id").val();
        });

        $("#branch_id").change(function() {
            window.location.href = "{{ route('appointments.index') }}?from=" + start + "&to=" + end + "&doctor=" +
                $("#doctor_id").val() + "&branch=" + $(this).val();
        });
    </script>
@endsection
