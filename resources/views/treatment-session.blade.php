@extends('layouts.treatment-layout')

@section('title', 'Treatment Session')

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
                fill: #c0bfbf !important;
                cursor: pointer;
            }

            .selected {
                fill: #ffcc00 !important;
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
    </style>
@endsection

@section('content')
    @if ($data->appointment->patient->medical_history)
        <div class="alert alert-danger" role="alert">
            <span class="fe fe-minus-circle fe-16 mr-2"></span>Medical History >>
            {{ $data->appointment->patient->medical_history }}
        </div>
    @endif

    <div class="alert alert-info" role="alert">
        <div class="row">
            <p class="col-2 mb-0 d-flex align-items-baseline">
                <span class="fe fe-16 fe-clock"></span>
                <span id="counter" class="ml-2">00:00:00</span>
            </p>
            <p class="col-8 mb-0">#{{ $data->appointment->patient->id }} | {{ $data->appointment->patient->name }} |
                {{ $data->appointment->patient->age }} years old | {{ $data->appointment->patient->nationality }} |
                {{ $data->appointment->patient->phone }} | {{ $data->appointment->patient->phone2 }}</p>
            <div class="col-2">
                <span class="d-flex align-items-center justify-content-center">
                    Take Invoice :
                    @if ($data->appointment->patient->need_invoice)
                        <span class="ml-2 fe fe-16 fe-check-circle"></span>
                    @else
                        <span class="ml-2 fe fe-16 fe-x-circle"></span>
                    @endif
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" onclick="clearDataTeeth()" id="Permanent-tab" data-toggle="pill"
                                href="#Permanent" role="tab" aria-controls="Permanent"
                                aria-selected="true">Permanent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="clearDataTeeth()" id="Deciduous-tab" data-toggle="pill"
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
                <div class="card-body invisible" id="div-diagnosis">
                    <div class="form-group">
                        <label for="doctor_id">Diagnosis</label>
                        <select class="form-control select2" id="simple-select2" name="patient_id">
                            <option value="0"></option>
                            @foreach ($data->diagnosis as $diagnose)
                                <option value="{{ $diagnose->id }}">{{ $diagnose->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-7">
            <div class="mb-2">
                <div class="card shadow">
                    <div class="card-body"></div>
                </div>
            </div>
            <div>
                <div class="card shadow">
                    <div class="card-body" id="treatment-tabs">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="card-title">Panorama</h5>
                        <div id="panorama" class="splide" role="group" aria-label="Splide Basic HTML Example">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @if (count($data->panorama) > 0)
                                        @foreach ($data->panorama as $img)
                                            <li class="splide__slide" data-toggle="modal"
                                                data-target="#panorama{{ $img['id'] }}"><img src="{{ $img['url'] }}"
                                                    alt=""></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h5 class="card-title">Tooth</h5>
                        <div id="teeth" class="splide" role="group" aria-label="Splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide"><img src="{{ asset('images/female_avatar.jpg') }}"
                                            alt="">
                                    </li>
                                    <li class="splide__slide"><img src="{{ asset('images/female_avatar.jpg') }}"
                                            alt="">
                                    </li>
                                    <li class="splide__slide"><img src="{{ asset('images/female_avatar.jpg') }}"
                                            alt="">
                                    </li>
                                    <li class="splide__slide"><img src="{{ asset('images/female_avatar.jpg') }}"
                                            alt="">
                                    </li>
                                    <li class="splide__slide"><img src="{{ asset('images/female_avatar.jpg') }}"
                                            alt="">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    </div>
                </div>
            </div> <!-- small modal -->
        @endforeach
    @endif
@endsection

@section('script')
    <script>
        let totalSeconds = 0;
        let selectedTooth = 0;

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
                    $("polygon").removeClass("selected");
                    $("path").removeClass("selected");

                    // Toggle the selected class to change the color
                    $(this).toggleClass("selected");
                }

                selectedTooth = toothNumber;

                if (selectedTooth != 0) {
                    $("#div-diagnosis").removeClass("invisible");
                } else {
                    $("#div-diagnosis").addClass("invisible");
                }

                getTreatmentsTabs();
            });
        });

        $(document).on("change", "#simple-select2", function() {
            getTreatmentsTabs();
        })

        function clearDataTeeth() {
            selectedTooth = 0;
            $("polygon").removeClass("selected");
            $("path").removeClass("selected");
            $("#div-diagnosis").addClass("invisible");
        }

        function getTreatmentsTabs() {
            const diagnose = $("#simple-select2").val();

            if (diagnose != 0 && selectedTooth != 0) {
                $.ajax({
                    url: "{{ route('treatment.tabs') }}",
                    type: "GET",
                    data: {
                        diagnose: diagnose,
                        teeth: selectedTooth
                    },
                    success: function(response) {
                        console.log(response.html);

                        $("#treatment-tabs").html(response.html);
                    }
                });
            }
        }
    </script>
@endsection
