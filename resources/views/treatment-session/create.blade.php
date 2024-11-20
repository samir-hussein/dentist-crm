@extends('layouts.treatment-layout')

@section('title', 'Treatment Session')

@section('style')
    <style>
        .tooth-chart {
            width: 100%;
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
        }

        .splide img {
            width: 100%;
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
    @if ($data->patient->medical_history)
        <div class="alert alert-danger" role="alert">
            <span class="fe fe-minus-circle fe-16 mr-2"></span>Medical History >>
            {{ $data->patient->medical_history }}
        </div>
    @endif

    <div class="alert alert-info" role="alert">
        <div class="row">
            <p class="col-12 col-md-8 mb-0">#{{ $data->patient->code }} | {{ $data->patient->name }} |
                {{ $data->patient->age }} years old | {{ $data->patient->nationality }} |
                {{ $data->patient->phone }} | {{ $data->patient->phone2 }}</p>
            <div class="col-6 col-md-2">
                <span class="d-flex align-items-center justify-content-center"
                    style="color: #d82525;font-weight: bolder;font-size:18px">
                    Take Invoice :
                    @if ($data->patient->need_invoice)
                        <span class="ml-2 fe fe-16 fe-check-circle"
                            style="color: #d82525;font-weight: bolder;font-size:18px"></span>
                    @else
                        <span class="ml-2 fe fe-16 fe-x-circle"
                            style="color: #d82525;font-weight: bolder;font-size:18px"></span>
                    @endif
                </span>
            </div>
            <p class="col-6 col-md-2 mb-0 d-flex align-items-baseline">
                <span class="fe fe-16 fe-clock"></span>
                <span id="counter" class="ml-2">00:00:00</span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" onclick="clearDataTeeth('permanent')" id="Permanent-tab"
                                data-toggle="pill" href="#Permanent" role="tab" aria-controls="Permanent"
                                aria-selected="true">Permanent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="clearDataTeeth('deciduous')" id="Deciduous-tab" data-toggle="pill"
                                href="#Deciduous" role="tab" aria-controls="Deciduous"
                                aria-selected="false">Deciduous</a>
                        </li>
                    </ul>
                    <div class="tab-content mb-1" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="Permanent" role="tabpanel"
                            aria-labelledby="Permanent-tab">
                            <x-tooth-chart nameAttr="permanent" />
                        </div>
                        <div class="tab-pane fade" id="Deciduous" role="tabpanel" aria-labelledby="Deciduous-tab">
                            <x-child-tooth-chart nameAttr="deciduous" />
                        </div>
                    </div>
                </div>
                <div class="card-body invisible pt-0 pb-0" id="div-diagnosis">
                    <div class="form-group">
                        <label for="diagnose">Diagnosis</label>
                        <select class="form-control select2" id="diagnose" name="patient_id">
                            <option value="0"></option>
                            @foreach ($data->diagnosis as $diagnose)
                                <option value="{{ $diagnose->id }}">{{ $diagnose->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body form-row pt-0 pb-0">
                    <div class="form-group col-6 col-md-12 invisible" id="div-upload-tooth">
                        <button class="btn btn-secondary w-100" id="tooth-btn">Upload Tooth X-Ray</button>
                        <input type="file" hidden id="tooth-inp" multiple>
                    </div>
                    <div class="form-group col-6 col-md-12">
                        <button class="btn btn-info w-100" id="panorama-btn">Upload Panorama</button>
                        <input type="file" hidden id="panorama-inp" multiple>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-7">
            <div class="mb-2">
                <div class="card shadow">
                    <div class="card-body" id="treatment-tabs">

                    </div>
                </div>
            </div>
            <div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-6 col-md-4">
                                <label for="fees">Fees</label>
                                <input type="number" step="100" id="fees" class="form-control" min="0">
                            </div>
                            <div class="form-group col-6 col-md-4">
                                <label for="paid">Down Payment</label>
                                <input type="number" step="100" id="paid" class="form-control" min="0">
                            </div>
                            <div class="form-group col-6 col-md-4 d-flex align-items-end justify-content-center">
                                <button class="btn w-100 btn-warning" data-toggle="modal"
                                    data-target=".prescription-modal">Prescription</button>
                            </div>
                            <div class="form-group col-6 col-md-4 d-flex align-items-end justify-content-center">
                                <button class="btn w-100 btn-primary" id="save">Save</button>
                            </div>
                            <div class="form-group col-6 col-md-4 d-flex align-items-end justify-content-center">
                                <button class="btn w-100 btn-success" id="done">Done</button>
                            </div>
                            <div class="form-group col-6 col-md-4 d-flex align-items-end justify-content-center">
                                <a class="w-100"
                                    href="{{ route('patients.file', ['patient' => $data->patient->id]) }}"><button
                                        class="btn w-100 btn-danger">Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="mb-4" id="panorama-img">
                        <h5 class="card-title">Panorama</h5>
                        <div id="panorama" class="splide" role="group" aria-label="Splide Basic HTML Example">
                            <div class="splide__track">
                                <ul class="splide__list" id="panorama-slider">
                                    @if (count($data->panorama) > 0)
                                        @foreach ($data->panorama as $img)
                                            <li class="splide__slide" data-toggle="modal"
                                                data-target="#panorama{{ $img['id'] }}"><img
                                                    src="{{ $img['url'] }}" alt=""></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="tooth-img">
                        <h5 class="card-title">Tooth</h5>
                        <div id="teeth" class="splide" role="group" aria-label="Splide">
                            <div class="splide__track">
                                <ul class="splide__list" id="tooth-panorama-slider">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="panorama-modals">
        @if (count($data->panorama) > 0)
            @foreach ($data->panorama as $img)
                <div class="modal fade" id="panorama{{ $img['id'] }}" tabindex="-1" role="dialog"
                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img src="{{ $img['url'] }}" alt="">
                            </div>
                            <button class="btn btn-danger del-panorama" data-id="{{ $img['id'] }}">Delete</button>
                        </div>
                    </div>
                </div> <!-- small modal -->
            @endforeach
        @endif
    </div>

    <div id="tooth-modals">

    </div>

    <div class="modal fade prescription-modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div id="medicines">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Type</label>
                                                <select class="types form-control select2" name="patient_id">
                                                    @foreach ($data->medicines as $medicine)
                                                        <option value="{{ $medicine->name }}"
                                                            data-medicines="{{ json_encode($medicine->medicine) }}">
                                                            {{ $medicine->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Medicine</label>
                                                <select class="form-control select2 medicines-options" name="medicines">
                                                    @foreach ($data->medicines[0]->medicine as $medicine)
                                                        <option value="{{ $medicine }}">
                                                            {{ $medicine }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Dose</label>
                                                <select class="form-control select2 dose" name="doses">
                                                    @foreach ($data->doses as $dose)
                                                        <option value="{{ $dose }}">
                                                            {{ $dose }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-2">
                                        <button type="button" id="add-medicine" class="btn btn-warning">Add
                                            Medicine</button>
                                    </div>
                                    <div id="print-area" style="display:none">
                                        <table style="width: 80%; margin-top:110px">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">
                                                        Date</td>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">:
                                                    </td>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">
                                                        {{ date('d-m-Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">
                                                        Name</td>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">:
                                                    </td>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">
                                                        {{ $data->patient->name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">
                                                        Diagnosis</td>
                                                    <td style="padding-bottom: 5px;font-size: 19px;">:
                                                    </td>
                                                    <td style="padding-bottom: 5px;font-size: 19px;" id="print-diagnosis">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 60px;font-family:cursive;font-weight:bolder">R/
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table style="width: 95%;margin-left:auto;margin-top:5px">
                                            <tbody id="print-medicines-list">

                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="generate-print" class="btn btn-primary">Print</button>
                                </div> <!-- /. card-body -->
                            </div> <!-- /. card -->
                        </div> <!-- /. col -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- large modal -->
@endsection

@section('script')
    <script>
        let totalSeconds = 0;
        let selectedTooth = [];
        let selectedAttr = [];
        let diagnose = null;
        let labWork = [];
        let attrInputs = {};
        let labData = {};
        let lab_id = null;
        let lab_done = false;
        let tooth_type = "permanent";

        $("#panorama-btn").click(function() {
            $("#panorama-inp").trigger("click");
        })

        $("#tooth-btn").click(function() {
            $("#tooth-inp").trigger("click");
        })

        $("#panorama-inp").on("change", function() {
            let formData = new FormData();

            // Get files from both inputs
            let panoramaFiles = $("#panorama-inp")[0].files;

            // Append files to the FormData object
            for (let i = 0; i < panoramaFiles.length; i++) {
                formData.append("panorama_files[]", panoramaFiles[i]);
            }

            // Send the data via AJAX
            $.ajax({
                url: "/panorama/{{ $data->patient->id }}/upload-files", // Replace with your route URL
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#panorama-img").html(response.html.slider);
                    $("#panorama-modals").html(response.html.modals);
                    new Splide('#panorama-uploaded').mount();
                },
                error: function(xhr) {
                    console.error("Error uploading files:", xhr.responseText);
                }
            });
        });

        $("#tooth-inp").on("change", function() {
            let formData = new FormData();

            // Get files from both inputs
            let panoramaFiles = $("#tooth-inp")[0].files;

            // Append files to the FormData object
            for (let i = 0; i < panoramaFiles.length; i++) {
                formData.append("panorama_files[]", panoramaFiles[i]);
            }

            // Send the data via AJAX
            $.ajax({
                url: "/tooth/{{ $data->patient->id }}/upload-files/" +
                    selectedTooth.join("-"), // Replace with your route URL
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#tooth-img").html(response.html.slider);
                    $("#tooth-modals").html(response.html.modals);
                    new Splide('#tooth-uploaded').mount();
                },
                error: function(xhr) {
                    console.error("Error uploading files:", xhr.responseText);
                }
            });
        });

        $(document).on('click', '.del-panorama', function() {
            let id = $(this).data("id");
            $.ajax({
                url: "/panorama/{{ $data->patient->id }}/" + id,
                type: "DELETE",
                success: function(response) {
                    $("#panorama-img").html(response.html.slider);
                    $("#panorama-modals").html(response.html.modals);
                    new Splide('#panorama-uploaded').mount();

                    let modal = $('#panorama' + id);
                    modal.modal('hide'); // Try the Bootstrap hide method
                    modal.removeClass('show'); // Remove Bootstrap's 'show' class
                    $('body').removeClass('modal-open'); // Remove modal-open class from body
                    $('.modal-backdrop').remove(); // Remove the backdrop explicitly
                },
                error: function(xhr) {
                    console.error("Error deleting file:", xhr.responseText);
                }
            });
        })

        $(document).on('click', '.del-tooth', function() {
            let id = $(this).data("id");
            $.ajax({
                url: "/tooth/{{ $data->patient->id }}/" + id + "/" + selectedTooth.join("-"),
                type: "DELETE",
                success: function(response) {
                    $("#tooth-img").html(response.html.slider);
                    $("#tooth-modals").html(response.html.modals);
                    new Splide('#tooth-uploaded').mount();

                    let modal = $('#panorama' + id);
                    modal.modal('hide'); // Try the Bootstrap hide method
                    modal.removeClass('show'); // Remove Bootstrap's 'show' class
                    $('body').removeClass('modal-open'); // Remove modal-open class from body
                    $('.modal-backdrop').remove(); // Remove the backdrop explicitly
                },
                error: function(xhr) {
                    console.error("Error deleting file:", xhr.responseText);
                }
            });
        })

        setInterval(() => {
            totalSeconds++;
            document.getElementById("counter").textContent = formatTime(totalSeconds);
        }, 1000);

        function formatTime(seconds) {
            const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const secs = String(seconds % 60).padStart(2, '0');
            return `${hrs}:${mins}:${secs}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            new Splide('#panorama').mount();
            new Splide('#teeth').mount();
        });

        $(document).ready(function() {
            // Event listener for selecting/deselecting a tooth
            $(document).on("click", "polygon, path", function() {
                const toothNumber = $(this).data("key"); // Get the data-key attribute (tooth number)

                // Ensure the toothNumber is defined before processing
                if (toothNumber !== undefined) {
                    // Toggle the selected class to change the color
                    $(this).toggleClass("selected");

                    if ($(this).hasClass("selected")) {
                        // Add tooth number to the array if selected
                        if (!selectedTooth.includes(toothNumber)) {
                            selectedTooth.push(toothNumber);
                        }
                    } else {
                        // Remove tooth number from the array if deselected
                        selectedTooth = selectedTooth.filter(num => num !== toothNumber);
                    }

                    if (selectedTooth.length > 0) {
                        $("#div-diagnosis").removeClass("invisible");
                        $("#div-upload-tooth").removeClass("invisible");
                    } else {
                        $("#div-upload-tooth").addClass("invisible");
                        $("#div-diagnosis").addClass("invisible");
                    }

                    getTreatmentsTabs();
                    getToothPanorama(selectedTooth.join("-"));
                }
            });
        });

        $(document).on("change", "#diagnose", function() {
            diagnose = $(this).val();
            getTreatmentsTabs();
        })

        $(document).on("change", ".select2", function() {
            lab_id = $(this).val();
        })

        $(document).on("change", ".lab-work", function() {
            selectElement = $(this)[0];
            labWork = Array.from(selectElement.selectedOptions).map(option => option.value);
        })

        $(document).on("keyup", ".attr-inputs", function() {
            // Set the value in attrInputs using the data-id as the key
            attrInputs[$(this).data("id")] = $(this).val();
        });

        $(document).on("focus", ".attr-inputs", function() {
            attrInputs[$(this).data("id")] = $(this).val();
        });

        $(document).on("keyup", ".lab-inputs", function() {
            // Set the value in attrInputs using the data-id as the key
            labData[$(this).data("attr")] = {};
            labData[$(this).data("attr")]['name'] = $(this).data('name');
            labData[$(this).data("attr")]['value'] = $(this).val();
        });

        $(document).on("focus", ".lab-inputs", function() {
            labData[$(this).data("attr")] = {};
            labData[$(this).data("attr")]['name'] = $(this).data('name');
            labData[$(this).data("attr")]['value'] = $(this).val();
        });

        function clearDataTeeth(type) {
            selectedTooth = [];
            selectedAttr = [];
            labWork = [];
            attrInputs = {};
            labData = {};
            lab_id = null;
            lab_done = false;
            tooth_type = type;

            $("polygon").removeClass("selected");
            $("path").removeClass("selected");
            $("#div-diagnosis").addClass("invisible");
            $("#div-upload-tooth").addClass("invisible");
            $("#treatment-tabs").html("");
        }

        function getTreatmentsTabs() {
            const diagnose = $("#diagnose").val();

            if (diagnose != 0 && selectedTooth.length != 0) {
                $.ajax({
                    url: "{{ route('treatment.tabs') }}",
                    type: "GET",
                    data: {
                        diagnose: diagnose,
                        teeth: selectedTooth,
                        tooth_type: tooth_type,
                    },
                    success: function(response) {
                        $("#treatment-tabs").html(response.html);

                        // Initialize Select2 on newly loaded elements
                        $('.select2').select2({
                            theme: 'bootstrap4',
                        });

                        $('.select2-multi').select2({
                            multiple: true,
                            theme: 'bootstrap4',
                        });

                        let need_lab = $("li[data-first='1']").data("needlab");

                        if (need_lab == 1) {
                            $('#lab-div').removeClass('d-none');
                        } else {
                            $('#lab-div').addClass('d-none');
                        }
                    }
                });
            }
        }

        function getToothPanorama(toothNumber) {
            $.ajax({
                url: `/patient/{{ $data->patient->id }}/tooth-panorama/${toothNumber}`,
                type: "GET",
                success: function(response) {
                    $("#tooth-img").html(response.html.slider);
                    $("#tooth-modals").html(response.html.modals);
                    new Splide('#tooth-uploaded').mount();
                }
            });
        }

        $(document).on('click', ".checkbox-inp", function() {
            const id = $(this).data('id');
            const attrId = $(this).data('attr');
            const checked = $(this).is(':checked');

            if (checked) {
                $('#' + id).removeClass('d-none');
                selectedAttr.push(attrId);
            } else {
                $('#' + id).addClass('d-none');
                selectedAttr = selectedAttr.filter(attr => attr != attrId);
                if (labData.hasOwnProperty(attrId)) {
                    delete labData[attrId];
                }
                $("input[data-attr='" + attrId + "']").val("");
            }
        })

        $(document).on('click', ".lab-done", function() {
            const checked = $(this).is(':checked');

            if (checked) {
                lab_done = true;
            } else {
                lab_done = false;
            }
        })

        let lastChecked = null;

        // Use event delegation on the document or a static container
        document.addEventListener('click', function(event) {
            if (event.target.matches('input[type="radio"]')) {
                const id = $(event.target).data('id');
                const attrId = $(event.target).data('attr');
                const section = id.split('-')[0];
                if (lastChecked === event.target) {
                    $('#' + id).addClass('d-none');
                    event.target.checked = false;
                    lastChecked = null;
                    selectedAttr = selectedAttr.filter(attr => attr != attrId);
                    if (labData.hasOwnProperty(attrId)) {
                        delete labData[attrId];
                    }
                    $("input[data-attr='" + attrId + "']").val("");
                } else {
                    $('.' + section).addClass('d-none');
                    $('#' + id).removeClass('d-none');
                    if (lastChecked) {
                        let lastAttr = $(lastChecked).data('attr');
                        selectedAttr = selectedAttr.filter(attr => attr !== lastAttr);
                    }
                    lastChecked = event.target;
                    selectedAttr.push(attrId);
                }
            }
        });
    </script>

    <script>
        $(document).on("change", ".types", function() {
            // Get the selected option
            let selectedOption = $(this).find('option:selected');

            // Get the data-medicines attribute as a JSON object
            let medicinesData = selectedOption.data('medicines');

            let html = "";

            medicinesData.forEach(function(medicine) {
                html += `<option value="${medicine}">${medicine}</option>`;
            });

            $(this).closest('.form-row').find(".medicines-options").html(html);
        })

        $(document).on("click", ".del-med", function() {
            $(this).closest('.form-row').remove();
        })

        $("#add-medicine").click(function() {
            $("#medicines").append(`
             <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Type</label>
                            <select class="types form-control select2" name="patient_id">
                                @foreach ($data->medicines as $medicine)
                                    <option value="{{ $medicine->name }}"
                                        data-medicines="{{ json_encode($medicine->medicine) }}">
                                        {{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Medicine</label>
                            <select class="form-control medicines-options select2" name="medicines">
                                @foreach ($data->medicines[0]->medicine as $medicine)
                                    <option value="{{ $medicine }}">
                                        {{ $medicine }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Dose</label>
                            <select class="form-control select2 dose" name="doses">
                                @foreach ($data->doses as $dose)
                                    <option value="{{ $dose }}">
                                        {{ $dose }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <button type="button" class="del-med btn btn-danger">remove</button>
                            </div>
                    </div>
        `);
        });

        $(document).ready(function() {
            $("#generate-print").click(function() {
                // Gather data for printing
                const diagnosis = $("#diagnose").find('option:selected').text()
                    .trim(); // Diagnose select

                if (!diagnose || diagnose == "") {
                    alert("Please select a diagnosis");
                    return false;
                }

                $("#print-diagnosis").text(diagnosis);

                // Medicines and doses
                let medicineList = "";
                $("#medicines .form-row").each(function() {
                    const medicine = $(this).find(".medicines-options option:selected").text()
                        .trim();
                    const dose = $(this).find(".dose option:selected").text().trim();
                    medicineList +=
                        `<tr><td style="padding-bottom: 5px;font-size: 19px;width:72%">${medicine}</td><td style="padding-bottom: 5px;font-size: 19px;"> ${dose}</td></tr>`;
                });
                $("#print-medicines-list").html(medicineList);

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
            });
        });
    </script>

    <script>
        $("#save").click(function() {
            const patient_id = "{{ $data->patient->id }}";
            const fees = $("#fees").val();
            const paid = $("#paid").val();
            let lab = {};

            if (!diagnose) {
                alert("Please select diagnose");
                return;
            }

            if (selectedAttr.length == 0) {
                alert("Please select at least one treatment");
                return;
            }

            if (!fees || !paid) {
                alert("Please enter fees and paid amount");
                return;
            }

            if (labWork.length > 0) {
                let sent = $("#sent").val();
                let cost = $("#cost").val();
                if (!lab_id || lab_id == "") {
                    alert("Please select lab");
                    return;
                }

                if (!sent || sent == "") {
                    alert("Please select date");
                    return;
                }

                lab = {
                    work: labWork,
                    custom_data: Object.keys(labData).length > 0 ? labData : null,
                    cost: cost,
                    sent: sent,
                    lab_id: lab_id,
                    done: lab_done ? 1 : 0
                };
            }

            $.ajax({
                url: "{{ route('treatment.session.store', ['patient' => $data->patient->id]) }}",
                method: "POST",
                data: {
                    diagnose_id: diagnose,
                    tooth: selectedTooth,
                    tooth_type: tooth_type,
                    fees: fees,
                    paid: paid,
                    data: {
                        attr: selectedAttr,
                        inputs: Object.keys(attrInputs).length > 0 ? attrInputs : null,
                        notes: $("#notes-inp").val() || null,
                    },
                    lab: Object.keys(lab).length > 0 ? lab : null,
                },
                success: function(response) {
                    if (response.status == "success") {
                        window.location.href =
                            "{{ route('patients.file', ['patient' => $data->patient->id]) }}";
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert(error.message);
                }
            });
        });

        $("#done").click(function() {
            const patient_id = "{{ $data->patient->id }}";
            const fees = $("#fees").val();
            const paid = $("#paid").val();
            let lab = {};

            if (!diagnose) {
                alert("Please select diagnose");
                return;
            }

            if (selectedAttr.length == 0) {
                alert("Please select at least one treatment");
                return;
            }

            if (!fees || !paid) {
                alert("Please enter fees and paid amount");
                return;
            }

            if (labWork.length > 0) {
                let sent = $("#sent").val();
                let cost = $("#cost").val();
                if (!lab_id || lab_id == "") {
                    alert("Please select lab");
                    return;
                }

                if (!sent || sent == "") {
                    alert("Please select date");
                    return;
                }

                lab = {
                    work: labWork,
                    custom_data: Object.keys(labData).length > 0 ? labData : null,
                    cost: cost,
                    sent: sent,
                    lab_id: lab_id,
                    done: lab_done ? 1 : 0
                };
            }

            $.ajax({
                url: "{{ route('treatment.session.store', ['patient' => $data->patient->id, 'appointment_id' => request('appointment_id')]) }}",
                method: "POST",
                data: {
                    diagnose_id: diagnose,
                    tooth: selectedTooth,
                    tooth_type: tooth_type,
                    fees: fees,
                    paid: paid,
                    data: {
                        attr: selectedAttr,
                        inputs: Object.keys(attrInputs).length > 0 ? attrInputs : null,
                        notes: $("#notes-inp").val() || null,
                    },
                    lab: Object.keys(lab).length > 0 ? lab : null,
                },
                success: function(response) {
                    if (response.status == "success") {
                        window.location.href =
                            "{{ route('patients.file', ['patient' => $data->patient->id]) }}";
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert(error.message);
                }
            });
        });

        $(document).on('click', '.tab-btn', function() {
            let need_lab = $(this).data('needlab');

            if (need_lab == 1) {
                $('#lab-div').removeClass('d-none');
            } else {
                $('#lab-div').addClass('d-none');
            }
        });
    </script>
@endsection
