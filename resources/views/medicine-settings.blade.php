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
        <div class="col-4 text-center">
            <div>
                <a href="{{ route('doses.index') }}" class="squircle bg-danger justify-content-center text-decoration-none">
                    <i class="fe fe-file-text fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('doses.index') }}" class="text-decoration-none">
                <p>Doses</p>
            </a>
        </div>
        <div class="col-4 text-center">
            <div>
                <a href="{{ route('medicine-types.index') }}"
                    class="squircle bg-warning justify-content-center text-decoration-none">
                    <i class="fe fe-list fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('medicine-types.index') }}" class="text-decoration-none">
                <p>Medicine Types</p>
            </a>
        </div>
        <div class="col-4 text-center">
            <div>
                <a href="{{ route('medicines.index') }}"
                    class="squircle bg-success justify-content-center text-decoration-none">
                    <i class="fe fe-thermometer fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('medicines.index') }}" class="text-decoration-none">
                <p>Medicines</p>
            </a>
        </div>
    </div>
@endsection
