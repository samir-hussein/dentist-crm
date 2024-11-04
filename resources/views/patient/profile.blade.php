@extends('layouts.main-layout')

@section('title', 'Patient Profile')

@section('buttons')
    <a href="{{ route('patients.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>

    <a href="#"
        onclick="window.open('{{ route('appointments.treatment', ['patient' => $patient->id]) }}', 'fullscreenWindow', 'width=' + screen.width + ',height=' + screen.height + ',left=0,top=0'); return false;">
        <button type="button" class="btn btn-primary">
            <span class="fe fe-plus fe-12 mr-2"></span>Start New Session
        </button>
    </a>
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
                fill: #c0bfbf;
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
                                    <p class="col-8 mb-0">#{{ $patient->id }} | {{ $patient->name }} |
                                        {{ $patient->age }} years old | {{ $patient->nationality }} |
                                        {{ $patient->phone }} | {{ $patient->phone2 }}</p>
                                    <div class="col-2">
                                        <span class="d-flex align-items-center justify-content-center">
                                            Take Invoice :
                                            @if ($patient->need_invoice)
                                                <span class="ml-2 fe fe-16 fe-check-circle"></span>
                                            @else
                                                <span class="ml-2 fe fe-16 fe-x-circle"></span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ isset($tooth[0]) ? (is_numeric($tooth[0]) ? 'active' : '') : 'active' }}"
                                        id="Permanent-tab" data-toggle="pill" href="#Permanent" role="tab"
                                        aria-controls="Permanent" aria-selected="true">Permanent</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ isset($tooth[0]) ? (is_numeric($tooth[0]) ? '' : 'active') : '' }}"
                                        id="Deciduous-tab" data-toggle="pill" href="#Deciduous" role="tab"
                                        aria-controls="Deciduous" aria-selected="false">Deciduous</a>
                                </li>
                            </ul>
                            <div class="tab-content mb-1" id="pills-tabContent">
                                <div class="tab-pane fade {{ isset($tooth[0]) ? (is_numeric($tooth[0]) ? 'show active' : '') : 'show active' }}"
                                    id="Permanent" role="tabpanel" aria-labelledby="Permanent-tab">
                                    <x-tooth-chart nameAttr="permanent" />
                                </div>
                                <div class="tab-pane fade {{ isset($tooth[0]) ? (is_numeric($tooth[0]) ? '' : 'show active') : '' }}"
                                    id="Deciduous" role="tabpanel" aria-labelledby="Deciduous-tab">
                                    <x-child-tooth-chart nameAttr="deciduous" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card-body">
                                <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="treatment-tab" data-toggle="pill" href="#treatment"
                                            role="tab" aria-controls="treatment" aria-selected="true">Treatment
                                            Sessions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="invoices-tab" data-toggle="pill" href="#invoices"
                                            role="tab" aria-controls="invoices" aria-selected="false">Invoices</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="lab-tab" data-toggle="pill" href="#lab" role="tab"
                                            aria-controls="lab" aria-selected="false">Lab</a>
                                    </li>
                                </ul>
                                <div class="tab-content mb-1" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="treatment" role="tabpanel"
                                        aria-labelledby="treatment-tab">
                                        <!-- Small table -->
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <!-- table -->
                                                <table class="table datatables" id="treatments">
                                                    <thead>
                                                        <tr>
                                                            <th>Tooth</th>
                                                            <th>Diagnose</th>
                                                            <th>Treatment</th>
                                                            <th>Date</th>
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
                                        invoices
                                    </div>
                                    <div class="tab-pane fade" id="lab" role="tabpanel" aria-labelledby="lab-tab">
                                        lab
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection

@section('script')
    <script>
        let selectedTooth = {!! json_encode($tooth ?? []) !!};
        let selectedToothNumber = "";

        selectedTooth.forEach(function(tooth) {
            $("polygon[data-key='" + tooth + "']").addClass("history");
        })

        function getTreatments(tooth = "") {
            if ($.fn.DataTable.isDataTable('#treatments')) {
                $('#treatments').DataTable().destroy();
            }

            $('#treatments').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('treatment.session.getAll', ['patient' => $patient->id]) }}" + "&tooth=" +
                        tooth, // Dynamically append tooth parameter
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.log(xhr.responseText); // Log the error for debugging
                    }
                },
                columns: [{
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
                        data: 'created_at',
                        name: 'Date'
                    },
                    {
                        data: null, // No field in the database for this, render buttons dynamically
                        name: 'action',
                        orderable: false, // Action buttons are not sortable
                        searchable: false, // Action buttons are not searchable
                        render: function(data, type, row) {
                            // Use JavaScript to construct URLs
                            var url = "/treatment-session/" + row.id + "/{{ $patient->id }}";
                            return `
            <a href="#" onclick="window.open('${url}', 'fullscreenWindow', 'width=' + screen.width + ',height=' + screen.height + ',left=0,top=0'); return false;" class="btn btn-sm btn-warning">Resume</a>
        `;
                        }
                    }
                ],
                pageLength: 10, // You can change the default page size here
                order: [] // Optional: Default sorting
            });
        }

        getTreatments();

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
            }
        });

        $("#treatment-tab").click(function() {
            getTreatments(selectedToothNumber);
        });
    </script>
@endsection
