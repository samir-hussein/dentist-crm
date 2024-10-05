@extends('layouts.main-layout')

@section('title', 'Patients')

@section('buttons')
    <a href="{{ route('patients.create') }}"><button type="button" class="btn btn-primary"><span
                class="fe fe-plus fe-12 mr-2"></span>Create</button></a>
@endsection

@section('content')
    @session('error')
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endsession

    @session('success')
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endsession
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
                                <th>Address</th>
                                {{-- <th>Action</th> --}}
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
                    data: 'address',
                    name: 'address'
                }
            ],
            pageLength: 10, // You can change the default page size here
            order: [] // Optional: Default sorting
        });
    </script>
@endsection
