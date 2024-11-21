@extends('layouts.main-layout')

@section('title', 'Assistant Shift Report')

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
                <div class="form-group col-6">
                    <label for="reportrange">Filter By Date : </label>
                    <div id="reportrange" class="border px-2 py-2 bg-light">
                        <i class="fe fe-calendar fe-16 mx-2"></i>
                        <span id="date-range"></span>
                    </div>
                </div>

                <div class="form-group col-6">
                    <label for="assistant">Filter By Assistant : </label>
                    <select id="assistant" name="assistant" class="form-control">
                        <option value="">All Assistants</option>
                        @foreach ($assistants as $assistant)
                            <option {{ request('assistant') == $assistant->id ? 'selected' : '' }}
                                value="{{ $assistant->id }}">
                                {{ $assistant->name }}
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
                                <th>Assistant Name</th>
                                <th>Morning Shifts</th>
                                <th>Night Shifts</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->assistant_name }}</td>
                                    <td>{{ $row->total_morning_shifts }}</td>
                                    <td>{{ $row->total_night_shifts }}</td>
                                    <td>{{ $row->total_shifts }}</td>
                                    <td>
                                        <button class="btn shift-dates btn-sm btn-warning" data-shift="morning"
                                            data-assistant="{{ $row->assistant_id }}">Morning Dates</button>
                                        <button class="btn shift-dates btn-info btn-sm" data-shift="night"
                                            data-assistant="{{ $row->assistant_id }}">Night Dates</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- simple table -->
    </div> <!-- end section -->


    <div class="modal fade shift-modal" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verticalModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="shift-dates-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Set initial start and end dates
        var urlParams = new URLSearchParams(window.location.search);
        var from = urlParams.get('from'); // Get 'from' parameter
        var to = urlParams.get('to'); // Get 'to' parameter
        var assistant = urlParams.get('assistant') ?? 0; // Get 'to' parameter

        // If 'from' and 'to' are present in the URL, use them; otherwise, default to the current month
        var start, end;

        if (from && to) {
            // Convert from and to to moment objects (assuming they are in the format of UNIX timestamps)
            start = moment(parseInt(from)); // Start time (from parameter)
            end = moment(parseInt(to)); // End time (to parameter)
        } else {
            // Default to the current month if no 'from' or 'to' in the URL
            start = moment().startOf('month'); // First day of the current month
            end = moment().endOf('month'); // Last day of the current month
        }

        $("#assistant").change(function() {
            assistant = $(this).val();
            window.location = "{{ route('assistants.shift.report') }}?assistant=" + assistant + "&from=" + start +
                "&to=" + end;
        })

        $('#dataTable-1').DataTable();

        // Callback function to display selected range
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        // Initialize date range picker
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
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

            window.location = "{{ route('assistants.shift.report') }}?assistant=" + assistant + "&from=" + start +
                "&to=" + end;
        });

        $(".shift-dates").on('click', function() {
            var shift = $(this).data('shift');
            var assistantId = $(this).data('assistant');

            $.ajax({
                url: `/assistants/${assistantId}/shift/${shift}/dates/${start}/${end}`,
                type: 'GET',
                success: function(response) {
                    $(".shift-modal").modal('show');
                    $(".modal-title").html(shift + " " + " shift dates");
                    $("#shift-dates-table tbody").html("");
                    response.forEach(function(date) {
                        $("#shift-dates-table tbody").append(
                            '<tr><td>' + date + '</td></tr>'
                        );
                    });
                }
            });
        });
    </script>
@endsection
