@extends('layouts.main-layout')

@section('settings-active', 'active-link')

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
                <a href="{{ route('lab-services.index') }}"
                    class="squircle bg-danger justify-content-center text-decoration-none">
                    <i class="fe fe-grid fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('lab-services.index') }}" class="text-decoration-none">
                <p>Lab Services</p>
            </a>
        </div>
        <div class="col-6 text-center">
            <div>
                <a href="{{ route('labs.index') }}" class="squircle bg-success justify-content-center text-decoration-none">
                    <i class="fe fe-filter fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('labs.index') }}" class="text-decoration-none">
                <p>Labs</p>
            </a>
        </div>
    </div>
@endsection
