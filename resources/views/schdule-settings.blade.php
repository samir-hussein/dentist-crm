@extends('layouts.main-layout')

@section('settings-active', 'active-link')

@section('page-path', 'SETTINGS > SCHEDULE')

@section('buttons')
    <a href="{{ route('settings') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('style')
    <style>
        a,
        a:hover {
            color: inherit;
        }
    </style>
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-6 text-center">
            <div>
                <a href="{{ route('schdule-days.index') }}"
                    class="squircle bg-danger justify-content-center text-decoration-none">
                    <i class="fe fe-calendar fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('schdule-days.index') }}" class="text-decoration-none">
                <p>Schedule Days</p>
            </a>
        </div>
        <div class="col-6 text-center">
            <div>
                <a href="{{ route('schdule-dates.index') }}"
                    class="squircle bg-success justify-content-center text-decoration-none">
                    <i class="fe fe-clock fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('schdule-dates.index') }}" class="text-decoration-none">
                <p>Schedule Dates</p>
            </a>
        </div>
    </div>
@endsection
