@extends('layouts.main-layout')

@section('title', 'Invoices')

@section('buttons')
    <button type="button" class="btn btn-success" id="export-excel">
        <span class="fe fe-share fe-12 mr-2"></span>Export
    </button>
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
                <div class="form-group col-6 col-md-4">
                    <label for="reportrange">Filter By Date : </label>
                    <div id="reportrange" class="border px-2 py-2 bg-light">
                        <i class="fe fe-calendar fe-16 mx-2"></i>
                        <span id="date-range"></span>
                    </div>
                </div>

                <div class="form-group col-6 col-md-4">
                    <label for="doctor_id">Filter By Dentist : </label>
                    <select id="doctor_id" name="doctor_id" class="form-control">
                        <option value="0">All Dentists</option>
                        @foreach ($doctors as $doctor)
                            <option {{ request('doctor') == $doctor->id ? 'selected' : '' }} value="{{ $doctor->id }}">
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label for="reportrange">Total Fees : </label>
                    <div class="alert alert-info" role="alert">
                        <span id="totalFees">0</span>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <label for="reportrange">Total Paid : </label>
                    <div class="alert alert-info" role="alert">
                        <span id="totalPaid">0</span>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Patient Id</th>
                                <th>Patient</th>
                                <th>Dentist</th>
                                <th>Tooth</th>
                                <th>Treatment</th>
                                <th>Fees</th>
                                <th>Paid</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection

@section('script')
    <script>
        // Set initial start and end dates
        var start = moment().startOf('month');
        var end = moment().endOf('month');
        let doctor = 0;

        $("#doctor_id").change(function() {
            doctor = $(this).val();
            getData(start, end);
        })

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
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
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

            getData(start, end);
        });

        getData(start, end);

        $("#export-excel").click(function() {
            $.ajax({
                url: "{{ route('invoices.report') }}?from=" + start + "&to=" + end + "&doctor=" + doctor +
                    "&excel=1",
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // Specify the response type as blob for file
                },
                success: function(response) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(response);
                    link.download = 'invoices.xlsx';
                    link.click();

                },
                error: function(xhr, error, code) {
                    console.log(xhr.responseText); // Log the error for debugging
                }
            });
        });

        function getData(from = "", to = "") {
            if ($.fn.DataTable.isDataTable('#dataTable-1')) {
                $('#dataTable-1').DataTable().destroy();
            }

            $('#dataTable-1').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('invoices.report') }}?from=" + from + "&to=" + to + "&doctor=" +
                        doctor, // URL to fetch data
                    type: 'GET',
                    dataSrc: function(json) {
                        // Access total_fees and total_paid from the server response
                        if (json.total_fees !== undefined && json.total_paid !== undefined) {
                            // Update the total fees and total paid in the DOM
                            $('#totalFees').text(json.total_fees);
                            $('#totalPaid').text(json.total_paid);
                        }
                        return json.data; // Ensure DataTables uses the data array
                    },
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error for debugging
                    }
                },
                columns: [{
                        data: 'id',
                        name: '#'
                    },
                    {
                        data: 'date',
                        name: 'Date',
                    },
                    {
                        data: 'patient_code',
                        name: 'Patient Id'
                    },
                    {
                        data: 'patient_name',
                        name: 'Patient'
                    },
                    {
                        data: 'doctor_name',
                        name: 'Dentist'
                    },
                    {
                        data: 'tooth',
                        name: 'Tooth'
                    },
                    {
                        data: 'treatment',
                        name: 'Treatment'
                    },
                    {
                        data: 'fees',
                        name: 'Fees'
                    },
                    {
                        data: 'paid',
                        name: 'Paid'
                    },
                ],
                pageLength: 10, // You can change the default page size here
                order: [] // Optional: Default sorting
            });
        }
    </script>
@endsection
