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
                            <select class="form-control select2" name="patient">
                                @foreach ($data->patients as $patient)
                                    <option value="{{ $patient->name }}">#{{ $patient->code }} |
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
                            <select class="form-control select2" name="diagnose">
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
                        <button type="button" id="add-medicine" class="btn btn-warning">Add Medicine</button>
                    </div>
                    <div id="print-area" style="display:none">
                        <table style="width: 80%; margin-top:110px">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom: 15px;font-size: 19px;">Date</td>
                                    <td style="padding-bottom: 15px;font-size: 19px;">:</td>
                                    <td style="padding-bottom: 15px;font-size: 19px;">
                                        {{ date('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 15px;font-size: 19px;">Name</td>
                                    <td style="padding-bottom: 15px;font-size: 19px;">:</td>
                                    <td style="padding-bottom: 15px;font-size: 19px;" id="print-patient-name"></td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 15px;font-size: 19px;">Diagnosis</td>
                                    <td style="padding-bottom: 15px;font-size: 19px;">:</td>
                                    <td style="padding-bottom: 15px;font-size: 19px;" id="print-diagnosis"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 60px;font-family:cursive;font-weight:bolder">R/</td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 85%;margin:auto;margin-top:15px">
                            <tbody id="print-medicines-list">

                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="generate-print" class="btn btn-primary">Print</button>
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
                const patientName = $("select[name='patient'] option:selected").val().trim();
                const diagnosis = $("select[name='diagnose']").find('option:selected').text()
                    .trim(); // Diagnose select

                // Fill in data in print section
                $("#print-patient-name").text(patientName);
                $("#print-diagnosis").text(diagnosis);

                // Medicines and doses
                let medicineList = "";
                $("#medicines .form-row").each(function() {
                    const medicine = $(this).find(".medicines-options option:selected").text()
                        .trim();
                    const dose = $(this).find(".dose option:selected").text().trim();
                    medicineList +=
                        `<tr><td style="padding-bottom: 15px;font-size: 19px;">${medicine}</td><td style="font-size: 19px;"> ${dose}</td></tr>`;
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
@endsection
