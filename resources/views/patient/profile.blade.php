@extends('layouts.main-layout')

@section('title', 'Patient File')

@section('buttons')
    <a href="{{ route('patients.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>

    @if (auth()->user()->is_admin || auth()->user()->is_doctor)
        <a href="{{ route('appointments.treatment', ['patient' => $patient->id]) }}">
            <button type="button" class="btn btn-primary">
                <span class="fe fe-plus fe-12 mr-2"></span>Start New Session
            </button>
        </a>
    @endif
@endsection

@section('style')
    <style>
        .tooth-chart {
            width: 200px;
        }

        .Spots {

            polygon,
            path {
                -webkit-transition: fill 0.25s;
                transition: fill 0.25s;
            }

            polygon:hover,
            polygon:active,
            path:hover,
            path:active {
                cursor: pointer;
            }

            .selected {
                fill: #ffcc00 !important;
            }

            .history {
                fill: #d82525;
            }
        }

        .splide img {
            width: 300px;
            height: 270px;
            object-fit: contain;
            background-color: white;
            cursor: pointer;
        }

        .modal-body img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .select2 {
            width: 100% !important;
        }

        .tooth-chart {
            margin: auto;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if ($patient->medical_history)
                                <div class="alert alert-danger" role="alert">
                                    <span class="fe fe-minus-circle fe-16 mr-2"></span>Medical History >>
                                    {{ $patient->medical_history }}
                                </div>
                            @endif

                            <div class="alert alert-info" role="alert">
                                <div class="row">
                                    <p class="col-12 col-md-10 mb-0">#{{ $patient->code }} | {{ $patient->name }} |
                                        {{ $patient->age }} years old | {{ $patient->nationality }} |
                                        {{ $patient->phone }} | {{ $patient->phone2 }}</p>
                                    <div class="col-md-2 col-12">
                                        <span class="d-flex align-items-center justify-content-center"
                                            style="color: #d82525;font-weight: bolder;font-size:18px">
                                            Take Invoice :
                                            @if ($patient->need_invoice)
                                                <span class="ml-2 fe fe-16 fe-check-circle"
                                                    style="color: #d82525;font-weight: bolder;font-size:18px"></span>
                                            @else
                                                <span class="ml-2 fe fe-16 fe-x-circle"
                                                    style="color: #d82525;font-weight: bolder;font-size:18px"></span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ isset($tooth[0]) ? ($tooth[0] < 50 ? 'active' : '') : 'active' }}"
                                        id="Permanent-tab" data-toggle="pill" href="#Permanent" role="tab"
                                        aria-controls="Permanent" aria-selected="true">Permanent</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ isset($tooth[0]) ? ($tooth[0] < 50 ? '' : 'active') : '' }}"
                                        id="Deciduous-tab" data-toggle="pill" href="#Deciduous" role="tab"
                                        aria-controls="Deciduous" aria-selected="false">Deciduous</a>
                                </li>
                            </ul>
                            <div class="tab-content mb-1" id="pills-tabContent">
                                <div class="tab-pane fade {{ isset($tooth[0]) ? ($tooth[0] < 50 ? 'show active' : '') : 'show active' }}"
                                    id="Permanent" role="tabpanel" aria-labelledby="Permanent-tab">
                                    <x-tooth-chart nameAttr="permanent" />
                                </div>
                                <div class="tab-pane fade {{ isset($tooth[0]) ? ($tooth[0] < 50 ? '' : 'show active') : '' }}"
                                    id="Deciduous" role="tabpanel" aria-labelledby="Deciduous-tab">
                                    <x-child-tooth-chart nameAttr="deciduous" />
                                </div>
                            </div>
                            @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                                <div>
                                    <button type="button" class="btn w-100 btn-info w-100" data-toggle="modal"
                                        data-target=".print-modal">Print Invoices</button>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="reportrange">Filter By Date : </label>
                                    <div id="reportrange" class="border px-2 py-2 bg-light">
                                        <i class="fe fe-calendar fe-16 mx-2"></i>
                                        <span id="date-range"></span>
                                    </div>
                                </div>
                                <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                                    @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                                        <li class="nav-item">
                                            <a class="nav-link active" id="treatment-tab" data-toggle="pill"
                                                href="#treatment" role="tab" aria-controls="treatment"
                                                aria-selected="true">Treatment
                                                Sessions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="invoices-tab" data-toggle="pill" href="#invoices"
                                                role="tab" aria-controls="invoices" aria-selected="false">Invoices</a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link {{ !auth()->user()->is_admin && !auth()->user()->is_doctor ? 'active' : '' }}"
                                            id="lab-tab" data-toggle="pill" href="#lab" role="tab"
                                            aria-controls="lab" aria-selected="false">Lab Orders</a>
                                    </li>
                                </ul>
                                <div class="tab-content mb-1" id="pills-tabContent">
                                    @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                                        <div class="tab-pane fade show active" id="treatment" role="tabpanel"
                                            aria-labelledby="treatment-tab">
                                            <!-- Small table -->
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <!-- table -->
                                                    <table class="table datatables" id="treatments">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Dentist</th>
                                                                <th>Tooth</th>
                                                                <th>Diagnosis</th>
                                                                <th>Treatment</th>
                                                                <th>Fees</th>
                                                                <th>Paid</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> <!-- simple table -->
                                        </div>
                                        <div class="tab-pane fade" id="invoices" role="tabpanel"
                                            aria-labelledby="invoices-tab">
                                            <!-- Small table -->
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <!-- table -->
                                                    <table class="table datatables" id="invoices-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Treatment</th>
                                                                <th>Tooth</th>
                                                                <th>Fees</th>
                                                                <th>Paid</th>
                                                                <th>Tax Invoice</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> <!-- simple table -->
                                        </div>
                                    @endif
                                    <div class="tab-pane fade {{ !auth()->user()->is_admin && !auth()->user()->is_doctor ? 'show active' : '' }}"
                                        id="lab" role="tabpanel" aria-labelledby="lab-tab">
                                        <!-- Small table -->
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <!-- table -->
                                                <table class="table datatables" id="lab-orders-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Work</th>
                                                            <th>Extra Data</th>
                                                            <th>Tooth</th>
                                                            <th>Lab</th>
                                                            <th>Sent Date</th>
                                                            <th>Received Date</th>
                                                            @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                                                                <th>Cost</th>
                                                                <th>Done</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> <!-- simple table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>

    <div class="modal fade print-modal" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verticalModalTitle">Print Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn mb-2 btn-warning" id="print-only"
                        data-dismiss="modal">Print</button>
                    <button type="button" class="btn mb-2 btn-primary" id="print-tax" data-dismiss="modal">Print & Send
                        To Tax</button>
                </div>
            </div>
        </div>
    </div>

    <div id="print-area" style="display:none">
        <table style="width: 80%; margin-top:110px">
            <tbody>
                <tr>
                    <td style="padding-bottom: 15px;font-size: 19px;">
                        Date</td>
                    <td style="padding-bottom: 15px;font-size: 19px;">:
                    </td>
                    <td style="padding-bottom: 15px;font-size: 19px;">
                        {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 15px;font-size: 19px;">
                        Name</td>
                    <td style="padding-bottom: 15px;font-size: 19px;">:
                    </td>
                    <td style="padding-bottom: 15px;font-size: 19px;">
                        {{ $patient->name }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%;margin-top:15px;border-collapse: collapse;">
            <thead>
                <tr style="text-align: left;border-top:1px solid black;padding: 1% 0 1% 0;border-bottom:1px solid black">
                    <th>No.</th>
                    <th>Date</th>
                    <th>Teeth</th>
                    <th>Treatment</th>
                    <th>Fees</th>
                    <th>Paid</th>
                </tr>
            </thead>
            <tbody id="print-list">

            </tbody>
        </table>
    </div>
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

            getTreatments(selectedToothNumber);
            getInvoices(selectedToothNumber);
            getLabOrders(selectedToothNumber);
        });

        let selectedTooth = {!! json_encode($tooth ?? []) !!};
        let selectedToothNumber = "";

        selectedTooth.forEach(function(tooth) {
            $("polygon[data-key='" + tooth + "']").addClass("history");
            $("path[data-key='" + tooth + "']").addClass("history");
        })

        function getTreatments(tooth = "") {
            if ($.fn.DataTable.isDataTable('#treatments')) {
                $('#treatments').DataTable().destroy();
            }

            $('#treatments').DataTable({
                processing: true,
                serverSide: true,
                ordering: false, // Disable ordering for all columns
                ajax: {
                    url: "{{ route('treatment.session.getAll', ['patient' => $patient->id]) }}" + "&tooth=" +
                        tooth + "&from=" + start + "&to=" + end, // Dynamically append tooth parameter
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error for debugging
                    }
                },
                columns: [{
                        data: 'created_at',
                        name: 'Date',
                    }, {
                        data: 'doctor',
                        name: 'Dentist',
                    }, {
                        data: 'tooth',
                        name: 'Tooth'
                    },
                    {
                        data: 'diagnose',
                        name: 'Diagnose'
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
                    {
                        data: null, // No field in the database for this, render buttons dynamically
                        name: 'action',
                        orderable: false, // Action buttons are not sortable
                        searchable: false, // Action buttons are not searchable
                        render: function(data, type, row) {
                            // Use JavaScript to construct URLs
                            var url = "/treatment-session/" + row.id + "/{{ $patient->id }}";
                            var staff =
                                "{{ !auth()->user()->is_admin && !auth()->user()->is_doctor ? true : false }}";

                            if (staff) {
                                return ``;
                            }
                            return `<a href="${url}" class="btn btn-sm btn-warning">Follow Up</a>`;
                        }
                    }
                ],
                pageLength: 10, // You can change the default page size here
                order: [] // Optional: Default sorting
            });
        }

        function getInvoices(tooth = "") {
            if ($.fn.DataTable.isDataTable('#invoices-table')) {
                $('#invoices-table').DataTable().destroy();
            }

            $('#invoices-table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false, // Disable ordering for all columns
                ajax: {
                    url: "{{ route('invoices.all', ['patient' => $patient->id]) }}" + "&tooth=" +
                        tooth + "&from=" + start + "&to=" + end, // Dynamically append tooth parameter
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
                        data: 'date',
                        name: 'Date',
                    },
                    {
                        data: 'treatment',
                        name: 'Treatment'
                    },
                    {
                        data: 'tooth',
                        name: 'Tooth'
                    },
                    {
                        data: 'fees',
                        name: 'Fees'
                    },
                    {
                        data: 'paid',
                        name: 'Paid'
                    },
                    {
                        data: null,
                        name: 'Tax Invoice',
                        orderable: false, // Action buttons are not sortable
                        searchable: false, // Action buttons are not searchable
                        render: function(data, type, row) {
                            if (row.tax_invoice) {
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
                            var url = "/treatment-session/" + row.id + "/{{ $patient->id }}";
                            var deleteUrl = '/invoices/' + row.id;
                            let id = row.id;

                            if (row.tax_invoice) {
                                return `
                                <button type="button" data-id="${id}" class="btn mb-2 btn-info btn-sm print-btn" data-toggle="modal"
                                    data-target=".print-modal">Print</button>
                                <form method="POST" action="${deleteUrl}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mb-2">Remove From Tax</button>
                            </form>
                                `;
                            }
                            return `<button type="button" data-id="${id}" class="btn btn-sm btn-info print-btn" data-toggle="modal"
                                    data-target=".print-modal">Print</button>`;
                        }
                    }
                ],
                pageLength: 10, // You can change the default page size here
                order: [] // Optional: Default sorting
            });
        }

        const userStaff = @json(!auth()->user()->is_admin && !auth()->user()->is_doctor);

        let columns = [];

        if (userStaff) {
            columns.push({
                data: 'id',
                name: '#'
            }, {
                data: 'work',
                name: 'Work'
            }, {
                data: 'custom_data',
                name: 'Extra Data'
            }, {
                data: 'tooth',
                name: 'Tooth'
            }, {
                data: 'lab',
                name: 'Lab'
            }, {
                data: null,
                name: 'Sent Date',
                orderable: false, // Action buttons are not sortable
                searchable: false, // Action buttons are not searchable
                render: function(data, type, row) {
                    let date = row.sent;
                    let id = row.id;
                    return `<input type="date" value="${date}" class="form-control date-change" data-name="sent" data-lab="${id}"/>`;
                }
            }, {
                data: null,
                name: 'Received Date',
                orderable: false, // Action buttons are not sortable
                searchable: false, // Action buttons are not searchable
                render: function(data, type, row) {
                    let date = row.received;
                    let id = row.id;
                    return `<input type="date" value="${date}" class="form-control date-change" data-name="received" data-lab="${id}"/>`;
                }
            });
        } else {
            columns.push({
                data: 'id',
                name: '#'
            }, {
                data: 'work',
                name: 'Work'
            }, {
                data: 'custom_data',
                name: 'Extra Data'
            }, {
                data: 'tooth',
                name: 'Tooth'
            }, {
                data: 'lab',
                name: 'Lab'
            }, {
                data: null,
                name: 'Sent Date',
                orderable: false, // Action buttons are not sortable
                searchable: false, // Action buttons are not searchable
                render: function(data, type, row) {
                    let date = row.sent;
                    let id = row.id;
                    return `<input type="date" value="${date}" class="form-control date-change" data-name="sent" data-lab="${id}"/>`;
                }
            }, {
                data: null,
                name: 'Received Date',
                orderable: false, // Action buttons are not sortable
                searchable: false, // Action buttons are not searchable
                render: function(data, type, row) {
                    let date = row.received;
                    let id = row.id;
                    return `<input type="date" value="${date}" class="form-control date-change" data-name="received" data-lab="${id}"/>`;
                }
            }, {
                data: 'cost',
                name: 'Cost',
            }, {
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
            });
        }

        function getLabOrders(tooth = "") {
            if ($.fn.DataTable.isDataTable('#lab-orders-table')) {
                $('#lab-orders-table').DataTable().destroy();
            }

            $('#lab-orders-table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false, // Disable ordering for all columns
                ajax: {
                    url: "{{ route('lab-orders.all', ['patient' => $patient->id]) }}" + "&tooth=" +
                        tooth + "&from=" + start + "&to=" + end, // Dynamically append tooth parameter
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error for debugging
                    }
                },
                columns: columns,
                pageLength: 10, // You can change the default page size here
                order: [] // Optional: Default sorting
            });
        }

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

        if (userStaff) {
            getLabOrders();
        } else {
            getTreatments();
        }

        $(document).on("click", "polygon, path", function() {
            let toothNumber = $(this).data("key"); // Get the data-key attribute (tooth number)

            // Ensure the toothNumber is defined before processing
            if (toothNumber !== undefined) {
                $("polygon").removeClass("selected");
                $("path").removeClass("selected");

                if (selectedToothNumber == toothNumber) {
                    selectedToothNumber = "";
                    // Toggle the selected class to change the color
                    $(this).removeClass("selected");
                } else {
                    selectedToothNumber = toothNumber;
                    $(this).addClass("selected");
                }

                getTreatments(selectedToothNumber);
                getInvoices(selectedToothNumber);
                getLabOrders(selectedToothNumber);
            }
        });

        $("#treatment-tab").click(function() {
            getTreatments(selectedToothNumber);
        });

        $("#invoices-tab").click(function() {
            getInvoices(selectedToothNumber);
        });

        $("#lab-tab").click(function() {
            getLabOrders(selectedToothNumber);
        });

        let last_print_id = null;

        $(document).on("click", ".print-btn", function() {
            last_print_id = $(this).data("id");
        });

        function print() {
            // Create an iFrame for printing
            let printWindow = window.open('', '_blank', 'width=1200,height=600');
            printWindow.document.write(`
            <html>
            <head></head>
            <body>${document.getElementById("print-area").innerHTML}</body>
            </html>
        `);
            printWindow.document.close(); // Finish writing to iFrame
            printWindow.focus();
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }

        $("#print-only").click(function() {
            $.ajax({
                url: `/invoices/print?patient={{ $patient->id }}&tooth=` + selectedToothNumber +
                    "&invoice=" + last_print_id + "&from=" + start + "&to=" + end,
                type: "GET",
                success: function(response) {
                    $("#print-list").html(response.html);
                    last_print_id = null;
                    print();
                }
            });
        });

        $("#print-tax").click(function() {
            $.ajax({
                url: `/invoices/print?patient={{ $patient->id }}&tooth=` + selectedToothNumber +
                    "&invoice=" + last_print_id + "&tax=1" + "&from=" + start + "&to=" + end,
                type: "GET",
                success: function(response) {
                    $("#print-list").html(response.html);
                    getInvoices(selectedToothNumber);
                    last_print_id = null;
                    print();
                }
            });
        });
    </script>
@endsection
