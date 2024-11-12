@extends('layouts.main-layout')

@section('title', 'Lab Orders Report')

@section('page-path', 'LAB ORDERS REPORT')

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
            <div class="form-group">
                <label for="reportrange">Filter By Date : </label>
                <div id="reportrange" class="border px-2 py-2 bg-light">
                    <i class="fe fe-calendar fe-16 mx-2"></i>
                    <span id="date-range"></span>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Patient</th>
                                <th>Patient Id</th>
                                <th>Work</th>
                                <th>Extra Data</th>
                                <th>Tooth</th>
                                <th>Lab</th>
                                <th>Sent Date</th>
                                <th>Received Date</th>
                                <th>Cost</th>
                                <th>Done</th>
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
                url: "{{ route('lab-order.report') }}?from=" + start + "&to=" + end + "&excel=1",
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // Specify the response type as blob for file
                },
                success: function(response) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(response);
                    link.download = 'lab_orders.xlsx';
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
                    url: "{{ route('lab-order.report') }}?from=" + from + "&to=" + to, // URL to fetch data
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error for debugging
                    }
                },
                columns: [{
                        data: 'date',
                        name: 'Order Date'
                    },
                    {
                        data: 'patient_name',
                        name: 'Patient'
                    },
                    {
                        data: 'patient_code',
                        name: 'Patient Id'
                    },
                    {
                        data: 'work',
                        name: 'Work'
                    },
                    {
                        data: 'custom_data',
                        name: 'Extra Data'
                    },
                    {
                        data: 'tooth',
                        name: 'Tooth'
                    },
                    {
                        data: 'lab',
                        name: 'Lab'
                    },
                    {
                        data: 'sent',
                        name: 'Sent Date',
                    },
                    {
                        data: 'received',
                        name: 'Received Date',
                    },
                    {
                        data: 'cost',
                        name: 'Cost',
                    },
                    {
                        data: null,
                        name: 'Done',
                        orderable: false, // Action buttons are not sortable
                        searchable: false, // Action buttons are not searchable
                        render: function(data, type, row) {
                            if (row.done) {
                                return `<span class="badge badge-warning">Yes</span>`;
                            }
                            return `<span class="badge badge-success">No</span>`;
                        }
                    }
                ],
                pageLength: 10, // You can change the default page size here
                order: [] // Optional: Default sorting
            });
        }
    </script>
@endsection
