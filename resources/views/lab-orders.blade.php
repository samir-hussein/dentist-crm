@extends('layouts.main-layout')

@section('title', 'Lab Orders')

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
                    <table class="table datatables" id="lab-orders-table">
                        <thead>
                            <tr>
                                <th>#</th>
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
        $('#lab-orders-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false, // Disable ordering for all columns
            ajax: {
                url: "{{ route('lab-orders.all') }}",
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
                    data: 'patient_name',
                    name: 'Patient'
                },
                {
                    data: 'patient_id',
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
                    data: null,
                    name: 'Sent Date',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        let date = row.sent;
                        let id = row.id;
                        return `<input type="date" value="${date}" class="form-control date-change" data-name="sent" data-lab="${id}"/>`;
                    }
                },
                {
                    data: null,
                    name: 'Received Date',
                    orderable: false, // Action buttons are not sortable
                    searchable: false, // Action buttons are not searchable
                    render: function(data, type, row) {
                        let date = row.received;
                        let id = row.id;
                        return `<input type="date" value="${date}" class="form-control date-change" data-name="received" data-lab="${id}"/>`;
                    }
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

        $(document).on("change", ".date-change", function() {
            let name = $(this).data("name");
            let value = $(this).val();
            let labOrder = $(this).data("lab");

            $.ajax({
                url: "/lab-orders/" + labOrder,
                type: 'PUT',
                data: {
                    [name]: value
                },
                success: function(response) {
                    alert("Updated Successfully");
                },
                error: function(xhr, error, code) {
                    console.log(xhr.responseText); // Log the error for debugging
                }
            });
        });
    </script>
@endsection
