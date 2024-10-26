@extends('layouts.main-layout')

@section('title', 'Prescription')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Patient</label>
                            <select class="form-control select2" name="patient_id">
                                @foreach ($data->patients as $patient)
                                    <option value="{{ $patient->id }}">#{{ $patient->id }} |
                                        {{ $patient->name }} |
                                        {{ $patient->phone }} | {{ $patient->phone2 }}
                                    </option>
                                @endforeach
                            </select>
                        </div> <!-- form-group -->
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Diagnose</label>
                            <select class="form-control select2" name="patient_id">
                                @foreach ($data->diagnosis as $diagnose)
                                    <option value="{{ $diagnose }}">
                                        {{ $diagnose }}
                                    </option>
                                @endforeach
                            </select>
                        </div> <!-- form-group -->
                    </div>

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
                                <select class="form-control select2 medicines-options" name="patient_id">
                                    @foreach ($data->medicines[0]->medicine as $medicine)
                                        <option value="{{ $medicine }}">
                                            {{ $medicine }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Dose</label>
                                <select class="form-control select2" name="patient_id">
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
                        <button type="button" id="add-medicine" class="btn btn-warning">Add Medicine</button>
                    </div>
                    <button type="button" class="btn btn-primary">Print</button>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection

@section('script')
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
                                <select class="form-control medicines-options select2" name="patient_id">
                                    @foreach ($data->medicines[0]->medicine as $medicine)
                                        <option value="{{ $medicine }}">
                                            {{ $medicine }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Dose</label>
                                <select class="form-control select2" name="patient_id">
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
    </script>
@endsection
