@extends('layouts.main-layout')

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
        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('admins.index') }}" class="squircle bg-danger justify-content-center text-decoration-none">
                    <i class="fe fe-users fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('admins.index') }}" class="text-decoration-none">
                <p>Admins</p>
            </a>
        </div>
        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('doctors.index') }}"
                    class="squircle bg-success justify-content-center text-decoration-none">
                    <i class="fe fe-users fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('doctors.index') }}" class="text-decoration-none">
                <p>Doctors</p>
            </a>
        </div>
        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('staff.index') }}"
                    class="squircle bg-primary justify-content-center text-decoration-none">
                    <i class="fe fe-users fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('staff.index') }}" class="text-decoration-none">
                <p>Staff</p>
            </a>
        </div>
        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('services.index') }}"
                    class="squircle bg-info justify-content-center text-decoration-none">
                    <i class="fe fe-archive fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('services.index') }}" class="text-decoration-none">
                <p>Services</p>
            </a>
        </div>
        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('diagnosis.index') }}"
                    class="squircle bg-warning justify-content-center text-decoration-none">
                    <i class="fe fe-sliders fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('diagnosis.index') }}" class="text-decoration-none">
                <p>Diagnosis</p>
            </a>
        </div>
        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('settings.lab-settings') }}"
                    class="squircle bg-secondary justify-content-center text-decoration-none">
                    <i class="fe fe-filter fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('settings.lab-settings') }}" class="text-decoration-none">
                <p>Labs Settings</p>
            </a>
        </div>

        <div class="col-6 col-md-4 text-center">
            <div>
                <a href="{{ route('settings.medicine-settings') }}"
                    class="squircle bg-primary justify-content-center text-decoration-none">
                    <i class="fe fe-thermometer fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('settings.medicine-settings') }}" class="text-decoration-none">
                <p>Medicine Settings</p>
            </a>
        </div>
    </div>
@endsection
