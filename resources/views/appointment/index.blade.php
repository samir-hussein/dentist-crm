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
                url: "{{ route('appointments.all') }}", // URL to fetch data
                type: 'GET',
                error: function(xhr, error, code) {
                    console.log(xhr.responseText); // Log the error for debugging
                }
            },
            columns: [{
                    data: 'visit_no',
                    name: 'Visit No.'
                },
                {
                    data: 'patientName',
                    name: 'Patient Name'
                },
                {
                    data: 'patientPhone',
                    name: 'Patient Phone'
                },
                {
                    data: 'patientPhone2',
                    name: 'Patient Phone 2'
                },
                {
                    data: 'doctorName',
                    name: 'Doctor Name'
                },
                {
                    data: 'servicesNames',
                    name: 'Services'
                },
                {
                    data: 'appointment',
                    name: 'Appointment'
                },
                {
                    data: null, // No field in the database for this, render buttons dynamically
                    name: 'action',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        // Use JavaScript to construct URLs
                        var completedUrl = '/appointments/' + row.id + '/completed';
                        var editUrl = '/appointments/' + row.id + '/edit';
                        var deleteUrl = '/appointments/' + row.id;

                        if (row.completed) {
                            return `<span class="text-success">Completed</span>`;
                        }

                        return `
                            <a href="${completedUrl}" class="mb-1 btn btn-sm btn-success">Mark as completed</a>
                            <a href="${editUrl}" class="btn mb-1 btn-sm btn-warning">Edit</a>
                            <form method="POST" action="${deleteUrl}" class="mb-1 d-inline"">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        `;
                    }
                }
            ],
            pageLength: 10, // You can change the default page size here
            order: [] // Optional: Default sorting
        });
    </script>
@endsection
