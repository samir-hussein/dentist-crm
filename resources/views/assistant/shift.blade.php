@extends('layouts.main-layout')

@section('title', 'Assistants')

@section('page-path', 'SETTINGS > Shift > ' . $assistant->name)

@section('settings-active', 'active-link')

@section('buttons')
    <button type="button" id="save-btn" class="btn btn-primary">
        <span class="fe fe-plus fe-12 mr-2"></span>Save
    </button>

    <a href="{{ route('assistants.index') }}"><button type="button" class="btn btn-dark"><span
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
                    <form action="{{ route('assistants.shift.store', ['assistant_id' => $assistant->id]) }}" method="post">
                        @csrf
                        <table class="table datatables" id="dataTable-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Day</th>
                                    <th>Date</th>
                                    <th>Morning Shift</th>
                                    <th>Night Shift</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $currentDate = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                                        $morningShift = $shifts[$currentDate]['morning_shift'] ?? false;
                                        $nightShift = $shifts[$currentDate]['night_shift'] ?? false;
                                    @endphp
                                    <tr>
                                        <td>{{ $day }}</td>
                                        <td>{{ \Carbon\Carbon::create($year, $month, $day)->format('l') }}</td>
                                        <td>{{ $currentDate }}</td>
                                        <td>
                                            <input type="checkbox" class="form-control w-25"
                                                name="shifts[{{ $currentDate }}][morning]" value="1"
                                                {{ $morningShift ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control w-25"
                                                name="shifts[{{ $currentDate }}][night]" value="1"
                                                {{ $nightShift ? 'checked' : '' }}>
                                        </td>
                                    </tr>
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
        $('#dataTable-1').DataTable({
            "pageLength": 31,
            "lengthMenu": [7, 10, 15, 31],
        });

        $("#save-btn").click(function() {
            $("#submit").click();
            return false;
        });

        $("#filter_date").change(function() {
            var date = $(this).val();
            if (!date) return false;

            window.location.href = "{{ route('assistants.shift', ['assistant_id' => $assistant->id]) }}?date=" +
                date;
        });
    </script>
@endsection
