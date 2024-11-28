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

        .disabled {
            pointer-events: none;
            /* Prevent clicks */
            color: gray;
            /* Change color to indicate it's disabled */
            cursor: not-allowed;
            /* Change cursor to indicate it's not clickable */
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
                            <a class="nav-link {{ $data->session->tooth[0] < 50 ? 'active' : '' }} disabled"
                                onclick="clearDataTeeth()" id="Permanent-tab" data-toggle="pill" href="#Permanent"
                                role="tab" aria-controls="Permanent" aria-selected="true">Permanent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $data->session->tooth[0] < 50 ? '' : 'active' }} disabled"
                                onclick="clearDataTeeth()" id="Deciduous-tab" data-toggle="pill" href="#Deciduous"
                                role="tab" aria-controls="Deciduous" aria-selected="false">Deciduous</a>
                        </li>
                    </ul>
                    <div class="tab-content mb-1" id="pills-tabContent">
                        <div class="tab-pane fade {{ $data->session->tooth[0] < 50 ? 'show active' : '' }}" id="Permanent"
                            role="tabpanel" aria-labelledby="Permanent-tab">
                            <x-tooth-chart nameAttr="permanent" />
                        </div>
                        <div class="tab-pane fade {{ $data->session->tooth[0] < 50 ? '' : 'show active' }}" id="Deciduous"
                            role="tabpanel" aria-labelledby="Deciduous-tab">
                            <x-child-tooth-chart nameAttr="deciduous" />
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-0" id="div-diagnosis">
                    <div class="form-group">
                        <label for="diagnose">Diagnosis</label>
                        <select class="form-control select2" id="diagnose" name="patient_id" disabled>
                            <option value="{{ $data->session->diagnose->id }}" selected>
                                {{ $data->session->diagnose->name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-body form-row pt-0 pb-0">
                    <div class="form-group col-6 col-md-12" id="div-upload-tooth">
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
                        @if (count($treatments) > 0)
                            <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                                @foreach ($treatments as $treatment)
                                    <li class="nav-item tab-btn" data-needlab="{{ $treatment->treatmentType->need_labs }}"
                                        data-first="{{ $loop->first ? 1 : 0 }}">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                            id="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}-tab"
                                            data-toggle="pill"
                                            href="#{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}"
                                            role="tab"
                                            aria-controls="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}"
                                            aria-selected="true">{{ $treatment->treatmentType->name }}</a>
                                    </li>
                                @endforeach
                                <li class="nav-item tab-btn" data-needlab="0">
                                    <a class="nav-link" id="notes-tab" data-toggle="pill" href="#notes" role="tab"
                                        aria-controls="notes" aria-selected="false">Write Notes</a>
                                </li>
                            </ul>
                            <div class="tab-content mb-1" id="pills-tabContent">
                                @foreach ($treatments as $treatment)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}"
                                        role="tabpanel"
                                        aria-labelledby="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}-tab">
                                        <div class="row">
                                            @foreach ($treatment->treatmentType->sections as $section)
                                                <div class="card-body col-6">
                                                    <h6>{{ $section->title }}</h6>
                                                    @if ($section->multi_selection)
                                                        @foreach ($section->attributes as $attribute)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" data-attr="{{ $attribute->id }}"
                                                                    data-id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}"
                                                                    class="checkbox-inp custom-control-input"
                                                                    id="{{ $section->id }}-{{ $attribute->id }}"
                                                                    {{ in_array($attribute->id, $data->session->data['attr']) ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                                            </div>
                                                            @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                                                <div class="mt-2 d-none"
                                                                    id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}">
                                                                    @foreach ($attribute->inputs as $input)
                                                                        <div class="form-group row">
                                                                            <label for="{{ $input->id }}"
                                                                                class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text"
                                                                                    class="form-control attr-inputs {{ $treatment->treatmentType->need_labs ? 'lab-inputs' : '' }}"
                                                                                    id="{{ $input->id }}"
                                                                                    data-name="{{ $input->name }}"
                                                                                    data-attr="{{ $attribute->id }}"
                                                                                    data-id="{{ $input->id }}"
                                                                                    value="{{ $data->session->data['inputs'] ? (in_array($input->id, array_keys($data->session->data['inputs'])) ? $data->session->data['inputs'][$input->id] : '') : '' }}">
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach ($section->attributes as $attribute)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" data-attr="{{ $attribute->id }}"
                                                                    data-id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}"
                                                                    id="{{ $section->id }}-{{ $attribute->id }}"
                                                                    name="customRadio{{ $section->id }}"
                                                                    class="custom-control-input"
                                                                    {{ in_array($attribute->id, $data->session->data['attr']) ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                                            </div>
                                                            @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                                                <div class="mt-2 d-none {{ str_replace([' ', '.'], '_', $section->title) }}"
                                                                    id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}">
                                                                    @foreach ($attribute->inputs as $input)
                                                                        <div class="form-group row">
                                                                            <label for="{{ $input->id }}"
                                                                                class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text"
                                                                                    class="form-control attr-inputs {{ $treatment->treatmentType->need_labs ? 'lab-inputs' : '' }}"
                                                                                    id="{{ $input->id }}"
                                                                                    data-id="{{ $input->id }}"
                                                                                    data-name="{{ $input->name }}"
                                                                                    data-attr="{{ $attribute->id }}"
                                                                                    value="{{ $data->session->data['inputs'] ? (in_array($input->id, array_keys($data->session->data['inputs'])) ? $data->session->data['inputs'][$input->id] : '') : '' }}">
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                                    <h6>Write Notes</h6>
                                    <textarea name="" dir="auto" class="form-control" id="notes-inp" cols="30" rows="10">{{ $data->session->data['notes'] }}</textarea>
                                    <div class="form-row">
                                        <!-- Voice Notes Section -->
                                        <div class="form-group col-12">
                                            <label for="voice_note">Notes (Voice)</label>
                                            <div id="voice-recorder">
                                                <button type="button" id="record-btn" class="btn btn-primary">Start
                                                    Recording</button>
                                                <button type="button" id="stop-btn" class="btn btn-danger"
                                                    disabled>Stop Recording</button>

                                                @if ($data->session->voiceNoteUrl)
                                                    <div class="mt-2">
                                                        <p>Previously Recorded Voice Note:</p>
                                                        <audio id="existing-audio" class="mt-2" controls>
                                                            <source src="{{ $data->session->voiceNoteUrl }}"
                                                                type="audio/webm">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </div>
                                                @endif

                                                <!-- Audio Preview for New Recording -->
                                                <audio id="audio-preview" class="mt-2" controls
                                                    style="display:none;"></audio>
                                                <input type="hidden" name="voice_note" id="voice-note-data">
                                            </div>
                                            @error('voice_note')
                                                <p style="color: red">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="lab-div" class="d-none p-2">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input lab-done"
                                            id="cementation-delivery"
                                            {{ $data->session->labOrder?->done ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="cementation-delivery">Done</label>
                                    </div> <!-- form-group -->
                                </div>
                                <h6>Lab Service</h6>
                                <div class="form-row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="select" class="d-block">Services</label>
                                        <select multiple class="form-control select2-multi lab-work d-block w-100"
                                            id="select" autocomplete="off">
                                            @foreach ($labsServices as $service)
                                                <option
                                                    {{ in_array($service->name, $data->session->labOrder?->work ? explode(' - ', $data->session->labOrder->work) : []) ? 'selected' : '' }}
                                                    value="{{ $service->name }}">{{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="simple-select">Labs</label>
                                        <select class="form-control select2 lab" id="simple-select">
                                            <option value="">select lab</option>
                                            @foreach ($labs as $lab)
                                                <option
                                                    {{ $data->session->labOrder?->lab_id == $lab->id ? 'selected' : '' }}
                                                    value="{{ $lab->id }}">{{ $lab->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> <!-- form-group -->
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12 col-md-6">
                                        <label>Charges</label>
                                        <input type="number" class="form-control" min="0" step="100"
                                            id="cost" autocomplete="new-password"
                                            value="{{ $data->session->labOrder?->cost }}">
                                    </div> <!-- form-group -->
                                    <div class="form-group col-12 col-md-6">
                                        <label>Date</label>
                                        <input type="date" class="form-control" id="sent"
                                            value="{{ optional($data->session->labOrder)->sent ? \Carbon\Carbon::parse($data->session->labOrder->sent)->format('Y-m-d') : '' }}">
                                    </div> <!-- form-group -->
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="form-row">
                            @if (auth()->user()->is_admin || (auth()->user()->is_doctor && auth()->user()->finance))
                                <div class="form-group col-6 col-md-3">
                                    <label for="fees">Fees</label>
                                    <input type="number" id="fees" class="form-control" min="0" disabled
                                        value="{{ $data->session->invoice[0]->fees }}" step="100">
                                </div>
                                <div class="form-group col-6 col-md-3">
                                    <label for="paid">Down Payment
                                        ({{ $data->session->invoice->sum('paid') }})</label>
                                    <input type="number" id="paid" class="form-control" min="0"
                                        value="0" step="100">
                                </div>
                            @endif
                            @if (auth()->user()->is_admin)
                                <div class="form-group col-6 col-md-3">
                                    <label for="paid">Dentist</label>
                                    <select id="doctor_id" name="doctor_id" class="form-control">
                                        <option value="">Select Dentist</option>
                                        @foreach ($doctors as $doctor)
                                            <option {{ $data->session->doctor_id == $doctor->id ? 'selected' : '' }}
                                                value="{{ $doctor->id }}">
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if (auth()->user()->is_admin || (auth()->user()->is_doctor && auth()->user()->finance))
                                <div class="form-group col-6 col-md-3 d-flex align-items-end justify-content-center">
                                    <button class="btn w-100 btn-info" data-toggle="modal"
                                        data-target=".invoices-modal">Invoices</button>
                                </div>
                            @endif
                            <div class="col-12 row">
                                <div class="form-group col-6 col-md-3 d-flex align-items-end justify-content-center">
                                    <button class="btn w-100 btn-warning" data-toggle="modal"
                                        data-target=".prescription-modal">Prescription</button>
                                </div>
                                <div class="form-group col-6 col-md-3 d-flex align-items-end justify-content-center">
                                    <button class="btn w-100 btn-primary" id="save">Save</button>
                                </div>
                                <div class="form-group col-6 col-md-3 d-flex align-items-end justify-content-center">
                                    <button class="btn w-100 btn-success" id="done">Done</button>
                                </div>
                                <div class="form-group col-6 col-md-3 d-flex align-items-end justify-content-center">
                                    <a class="w-100"
                                        href="{{ route('patients.file', ['patient' => $data->patient->id]) }}"><button
                                            class="btn w-100 btn-danger">Cancel</button></a>
                                </div>
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
                        {!! $data->tooth->slider !!}
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
        {!! $data->tooth->modals !!}
    </div>

    <div class="modal fade invoices-modal" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @php
                        $balance = $data->session->invoice->sum('paid') - $data->session->invoice[0]->fees;
                    @endphp
                    <h5 class="modal-title" id="verticalModalTitle">
                        {{ $balance > 0 ? 'Advance  ' . $balance : 'Balance  ' . $balance }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Paid</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->session->invoice as $invoice)
                                <tr>
                                    <td>{{ $invoice->paid }}</td>
                                    <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
        let selectedTooth = {!! json_encode($data->session->tooth ?? []) !!};
        let selectedAttr = [];
        let diagnose = "{{ $data->session->diagnose->id }}";
        let labWork = {!! json_encode($data->session->labOrder?->work ? explode(' - ', $data->session->labOrder->work) : []) !!};
        let attrInputs = {!! json_encode($data->session->data['inputs'] ?? []) !!};
        let labData = {!! json_encode($data->session->labOrder?->custom_data ?? []) !!};
        let lab_id = {!! json_encode($data->session->labOrder?->lab_id ?? null) !!};
        let lab_done = {!! json_encode($data->session->labOrder?->done ?? false) !!};

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

        selectedTooth.forEach(toothNumber => {
            $("polygon[data-key='" + toothNumber + "']").addClass("selected");
            $("path[data-key='" + toothNumber + "']").addClass("selected");
        });

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
            new Splide('#tooth-uploaded').mount();
        });

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

        $(".checkbox-inp").each(function() {
            const id = $(this).data('id');
            const attrId = $(this).data('attr');
            const checked = $(this).is(':checked');

            if (checked) {
                $('#' + id).removeClass('d-none'); // Show corresponding element
                selectedAttr.push(attrId); // Add to selected attributes
            } else {
                $('#' + id).addClass('d-none'); // Hide corresponding element
                selectedAttr = selectedAttr.filter(attr => attr != attrId); // Remove from selected attributes
                if (labData.hasOwnProperty(attrId)) {
                    delete labData[attrId]; // Remove from labData if it exists
                }
                $("input[data-attr='" + attrId + "']").val(""); // Clear input value
            }
        });

        $(document).on('click', ".lab-done", function() {
            const checked = $(this).is(':checked');

            if (checked) {
                lab_done = true;
            } else {
                lab_done = false;
            }
        })

        let lastChecked = {};

        $('input[type="radio"]').each(function() {
            const id = $(this).data('id');
            const attrId = $(this).data('attr');
            const section = id.split('-')[0];
            const groupName = $(this).attr('name'); // Get the group name of the radio button

            if ($(this).is(':checked')) {
                $('#' + id).removeClass('d-none'); // Show the relevant section
                lastChecked[groupName] = this; // Set lastChecked to the currently checked radio button
                selectedAttr.push(attrId); // Add to selected attributes
            } else {
                $('#' + id).addClass('d-none'); // Hide the section if not checked
            }
        });

        function initializeRecordingButtons() {
            const recordButton = document.getElementById('record-btn');
            const stopButton = document.getElementById('stop-btn');
            const audioPreview = document.getElementById('audio-preview');
            const voiceNoteData = document.getElementById('voice-note-data');

            let mediaRecorder;
            let audioChunks = [];

            // Initialize the record button functionality
            recordButton.addEventListener('click', async () => {
                // Request microphone access
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });
                    mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.ondataavailable = (event) => {
                        audioChunks.push(event.data);
                    };

                    mediaRecorder.onstop = async () => {
                        const audioBlob = new Blob(audioChunks, {
                            type: 'audio/webm'
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        audioPreview.src = audioUrl;
                        audioPreview.style.display = 'block';

                        // Convert audioBlob to Base64 for form submission
                        const reader = new FileReader();
                        reader.onloadend = () => {
                            voiceNoteData.value = reader.result.split(',')[
                                1]; // Base64 string
                        };
                        reader.readAsDataURL(audioBlob);

                        audioChunks = []; // Clear chunks for the next recording
                    };

                    mediaRecorder.start();
                    recordButton.disabled = true;
                    stopButton.disabled = false;
                } catch (err) {
                    alert('Could not access microphone: ' + err.message);
                }
            });

            // Initialize the stop button functionality
            stopButton.addEventListener('click', () => {
                if (mediaRecorder && mediaRecorder.state === 'recording') {
                    mediaRecorder.stop();
                    recordButton.disabled = false;
                    stopButton.disabled = true;
                }
            });
        }

        initializeRecordingButtons();

        // Use event delegation on the document or a static container
        document.addEventListener('click', function(event) {
            if (event.target.matches('input[type="radio"]')) {
                const id = $(event.target).data('id');
                const attrId = $(event.target).data('attr');
                const section = id.split('-')[0];
                const groupName = event.target.name; // Get the group name of the radio button

                if (lastChecked[groupName] === event.target) {
                    // Uncheck and reset if the same radio button is clicked again
                    $('#' + id).addClass('d-none');
                    event.target.checked = false;
                    lastChecked[groupName] = null;

                    // Remove the current attribute from selectedAttr
                    selectedAttr = selectedAttr.filter(attr => attr !== attrId);
                    if (labData.hasOwnProperty(attrId)) {
                        delete labData[attrId];
                    }
                    $("input[data-attr='" + attrId + "']").val("");
                } else {
                    // Hide all sections in the same group
                    $("input[name='" + groupName + "']").each(function() {
                        const otherId = $(this).data('id');
                        const otherAttrId = $(this).data('attr');

                        if (otherId !== id) {
                            $('#' + otherId).addClass('d-none');
                            selectedAttr = selectedAttr.filter(attr => attr !== otherAttrId);
                        }
                    });

                    // Show the current section
                    $('#' + id).removeClass('d-none');

                    // Update the selectedAttr list
                    if (lastChecked[groupName]) {
                        let lastAttr = $(lastChecked[groupName]).data('attr');
                        selectedAttr = selectedAttr.filter(attr => attr !== lastAttr);
                    }
                    lastChecked[groupName] = event.target;
                    selectedAttr.push(attrId);
                }
            }
        });

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
                const diagnosis = "{{ $data->session->diagnose->name }}"

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

        $("#save").click(function() {
            const patient_id = "{{ $data->patient->id }}";
            const fees = $("#fees").val();
            const paid = $("#paid").val();
            let lab = {};
            lab_id = $("#simple-select").val();

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
                url: "{{ route('treatment.session.update', ['treatment_detail' => $data->session->id, 'patient' => $data->patient->id]) }}",
                method: "PUT",
                data: {
                    paid: paid,
                    voice_note: $("#voice-note-data").val(),
                    doctor_id: $("#doctor_id").val(),
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
            lab_id = $("#simple-select").val();

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
                url: "{{ route('treatment.session.update', ['treatment_detail' => $data->session->id, 'patient' => $data->patient->id, 'appointment_id' => request('appointment_id')]) }}",
                method: "PUT",
                data: {
                    paid: paid,
                    doctor_id: $("#doctor_id").val(),
                    voice_note: $("#voice-note-data").val(),
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

        let need_lab = $("li[data-first='1']").data("needlab");

        if (need_lab == 1) {
            $('#lab-div').removeClass('d-none');
        } else {
            $('#lab-div').addClass('d-none');
        }

        $(document).on('click', '.tab-btn', function() {
            need_lab = $(this).data('needlab');

            if (need_lab == 1) {
                $('#lab-div').removeClass('d-none');
            } else {
                $('#lab-div').addClass('d-none');
            }
        });
    </script>
@endsection
