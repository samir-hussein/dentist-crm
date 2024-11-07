@extends('layouts.main-layout')

@section('title', 'Medicines')

@php
    $backPath = request('searchKey') ? 'medicine-types.index' : 'settings.medicine-settings';
    $prefix = request('searchKey')
        ? 'SETTINGS > MEDICINE SETTINGS > MEDICINE TYPES > '
        : 'SETTINGS > MEDICINE SETTINGS > ';
@endphp

@section('page-path-prefix', $prefix)

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('medicines.create') }}">
        <button type="button" class="btn btn-primary">
            <span class="fe fe-plus fe-12 mr-2"></span>Create
        </button>
    </a>

    <a href="{{ route($backPath) }}"><button type="button" class="btn btn-dark"><span
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
                                <th>Medicine Name</th>
                                <th>Medicine Type</th>
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
                url: "{{ route('medicines.all', ['searchKey' => request('searchKey')]) }}", // URL to fetch data
                type: 'GET',
                error: function(xhr, error, code) {
                    console.log(xhr.responseText); // Log the error for debugging
                }
            },
            columns: [{
                    data: 'name',
                    name: 'Medicine Name'
                },
                {
                    data: 'medicine_type.name',
                    name: 'Medicine Type'
                },
                {
                    data: null, // No field in the database for this, render buttons dynamically
                    name: 'action',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        // Use JavaScript to construct URLs
                        var editUrl = '/medicines/' + row.id + "/edit";
                        var deleteUrl = '/medicines/' + row.id;

                        return `
                            <a href="${editUrl}" class="btn btn-sm btn-info">Edit</a>
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
