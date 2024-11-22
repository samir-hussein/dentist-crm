@extends('layouts.main-layout')

@section('title', 'Assistants Shift')

@section('style')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('buttons')
    <button type="button" id="save-btn" class="btn btn-primary">
        <span class="fe fe-plus fe-12 mr-2"></span>Save
    </button>

    <a href="{{ route('home') }}"><button type="button" class="btn btn-dark"><span
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
                    <div class="form-group">
                        <input type="month" name="filter_date" id="filter_date" class="form-control"
                            value="{{ sprintf('%04d-%02d', $year, $month) }}">
                    </div>
                    <!-- table -->
                    <form action="{{ route('assistants.shift.store') }}" method="post">
                        @csrf
                        <table class="table datatables" id="dataTable-1">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Date</th>
                                    <th>Morning Shift</th>
                                    <th>Night Shift</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $today = 0;
                                @endphp
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $currentDate = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                                        $morningShift = $shifts[$currentDate]['morning_shift'] ?? [];
                                        $nightShift = $shifts[$currentDate]['night_shift'] ?? [];
                                        if ($currentDate == date('Y-m-d')) {
                                            $today = $day - 1;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ \Carbon\Carbon::create($year, $month, $day)->format('l') }}</td>
                                        <td class="w-25">{{ $currentDate }}</td>
                                        <td>
                                            <select multiple name="shifts[{{ $currentDate }}][morning][]"
                                                class="form-control select2-multi d-block w-100"
                                                id="multi-select{{ $day }}">
                                                @foreach ($assistants as $assistant)
                                                    <option value="{{ $assistant->id }}"
                                                        {{ in_array($assistant->id, $morningShift) ? 'selected' : '' }}>
                                                        {{ $assistant->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select multiple name="shifts[{{ $currentDate }}][night][]"
                                                class="form-control select2-multi d-block w-100"
                                                id="multi-select-{{ $day }}">
                                                @foreach ($assistants as $assistant)
                                                    <option value="{{ $assistant->id }}"
                                                        {{ in_array($assistant->id, $nightShift) ? 'selected' : '' }}>
                                                        {{ $assistant->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- Hidden inputs for all rows to ensure they are submitted -->
                                    @foreach ($morningShift as $assistantId)
                                        <input type="text" hidden name="shifts[{{ $currentDate }}][morning][]"
                                            value="{{ $assistantId }}">
                                    @endforeach
                                    @foreach ($nightShift as $assistantId)
                                        <input type="text" hidden name="shifts[{{ $currentDate }}][night][]"
                                            value="{{ $assistantId }}">
                                    @endforeach
                                @endfor
                            </tbody>
                        </table>

                        <button type="submit" hidden id="submit">save</button>
                    </form>
                </div>
            </div>
        </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection

@section('script')
    <script>
        let table = $('#dataTable-1').DataTable({
            "pageLength": 1,
            "lengthMenu": [1, 31],
            order: []
        });

        table.page({!! json_encode($today) !!}).draw(false);

        table.on('length.dt', function(e, settings, len) {
            if (len == 1) {
                table.page({!! json_encode($today) !!}).draw(false);
            }
        });

        $("#save-btn").click(function() {
            $("#submit").click();
            return false;
        });

        $("#filter_date").change(function() {
            var date = $(this).val();
            if (!date) return false;

            window.location.href = "{{ route('assistants.shift') }}?date=" +
                date;
        });
    </script>
@endsection
