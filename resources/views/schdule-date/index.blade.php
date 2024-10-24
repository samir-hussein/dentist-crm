@extends('layouts.main-layout')

@section('title', 'Schdule Dates')

@section('page-path-prefix', 'SETTINGS > SCHDULE SETTINGS > ')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('settings.schdule-settings') }}"><button type="button" class="btn btn-dark"><span
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
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Date</th>
                                <th>Holiday</th>
                                <th>Action</th>
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
        $('#dataTable-1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('schdule-dates.all') }}", // URL to fetch data
                type: 'GET',
                error: function(xhr, error, code) {
                    console.log(xhr.responseText); // Log the error for debugging
                }
            },
            columns: [{
                    data: 'day',
                    name: 'Day'
                },
                {
                    data: 'formated_date',
                    name: 'Date'
                },
                {
                    data: null, // No field in the database for this, render buttons dynamically
                    name: 'Holiday',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        if (row.is_holiday) {
                            return `<span class="badge badge-warning">Yes</span>`;
                        }
                        return `<span class="badge badge-success">No</span>`;
                    }
                },
                {
                    data: null, // No field in the database for this, render buttons dynamically
                    name: 'action',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        // Use JavaScript to construct URLs
                        var editUrl = '/schdule-dates/' + row.id + "/make-holiday";
                        var showUrl = '/schdule-dates/' + row.id;

                        if (row.is_holiday) {
                            return `
                            <a href="${editUrl}" class="btn btn-sm btn-warning">Make Work Day</a>
                        `;
                        }
                        return `
                            <a href="${editUrl}" class="btn btn-sm btn-info">Make Holiday</a>
                            <a href="${showUrl}" class="btn btn-sm btn-dark">Show Appointments</a>
                        `;
                    }
                }
            ],
            pageLength: 10, // You can change the default page size here
            order: [] // Optional: Default sorting
        });
    </script>
@endsection
