@extends('layouts.main-layout')

@section('title', 'Patients')

@section('buttons')
    <a href="{{ route('patients.create') }}">
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
                                <th>#</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Phone</th>
                                <th>Phone 2</th>
                                <th>Nationality</th>
                                <th>Need Invoice</th>
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
            ordering: false,
            ajax: {
                url: "{{ route('patients.all') }}", // URL to fetch data
                type: 'GET',
                error: function(xhr, error, code) {
                    console.log(xhr.responseText); // Log the error for debugging
                }
            },
            columns: [{
                    data: 'id',
                    name: '#'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'age',
                    name: 'age'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'phone2',
                    name: 'phone 2'
                },
                {
                    data: 'nationality',
                    name: 'Nationality'
                },
                {
                    data: null,
                    name: 'Need Invoice',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        if (row.need_invoice) {
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
                        var profileUrl = '/patients/' + row.id + '/profile';
                        var editUrl = '/patients/' + row.id + '/edit';
                        var deleteUrl = '/patients/' + row.id;
                        var staff =
                            "{{ !auth()->user()->is_admin && !auth()->user()->is_doctor ? true : false }}";

                        if (staff) {
                            return `
                            <a href="${profileUrl}" class="btn btn-sm btn-info">Profile</a>
                            <a href="${editUrl}" class="btn btn-sm btn-warning">Edit</a>
                        `;
                        }

                        return `
                            <a href="${profileUrl}" class="btn btn-sm btn-info">Profile</a>
                            <a href="${editUrl}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="${deleteUrl}" class="d-inline"">
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
