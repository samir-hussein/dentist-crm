@extends('layouts.main-layout')

@section('title', 'Schdule Pattern')

@section('page-path-prefix', 'SETTINGS > SCHDULE SETTINGS > ')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('schdule-days.index') }}"><button type="button" class="btn btn-dark"><span
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
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('schdule-days.update', ['schdule_day' => $data->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="simple-select2">Day</label>
                                <select class="form-control select2" id="simple-select2" name="day">
                                    <option {{ (old('day') ?? $data->day) == 'saturday' ? 'selected' : '' }}
                                        value="saturday">
                                        Saturday</option>
                                    <option {{ (old('day') ?? $data->day) == 'sunday' ? 'selected' : '' }} value="sunday">
                                        Sunday</option>
                                    <option {{ (old('day') ?? $data->day) == 'monday' ? 'selected' : '' }} value="monday">
                                        Monday</option>
                                    <option {{ (old('day') ?? $data->day) == 'tuesday' ? 'selected' : '' }} value="tuesday">
                                        Tuesday</option>
                                    <option {{ (old('day') ?? $data->day) == 'wednesday' ? 'selected' : '' }}
                                        value="wednesday">Wednesday</option>
                                    <option {{ (old('day') ?? $data->day) == 'thursday' ? 'selected' : '' }}
                                        value="thursday">Thursday</option>
                                    <option {{ (old('day') ?? $data->day) == 'friday' ? 'selected' : '' }} value="friday">
                                        Friday</option>
                                </select>
                                @error('day')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div> <!-- form-group -->
                        </div>
                        <div id="appointments">
                            @foreach ($data->pattern as $pattern)
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="time">Appointment Time</label>
                                        <input type="time" class="form-control" value="{{ $pattern->time }}"
                                            name="times[]" disabled>
                                        <button type="button"
                                            class="mt-2 delete-time btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-2">
                            <button type="button" id="add-appointment" class="btn btn-warning">Add Another
                                Appointment</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection

@section('script')
    <script>
        $(document).on("click", "#add-appointment", function() {
            var html =
                `
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="time">Appointment Time</label>
                        <input type="time" class="form-control" value="{{ old('times[]') }}" name="times[]">
                        @error('times[]')
                            <p style="color: red">* {{ $message }}</p>
                        @enderror
                        <button type="button" class="mt-2 delete-time btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
                `;
            $("#appointments").append(html);
        })

        $(document).on('click', ".delete-time", function() {
            $(this).closest('.form-row').remove();
        })
    </script>

@endsection
