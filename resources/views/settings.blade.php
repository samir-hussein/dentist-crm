@extends('layouts.main-layout')

@section('style')
    <style>
        a,
        a:hover {
            color: inherit;
        }

        .bg-calendar {
            background-color: #a569bd;
        }

        .bg-medicine {
            background-color: #ec7063;
        }

        .bg-medicine-type {
            background-color: #6495ED;
        }

        .bg-medical-history {
            background-color: #df58df;
        }

        .bg-branch {
            background-color: #4062be;
        }

        .bg-staff {
            background-color: #5c1f9d;
        }
    </style>
@endsection

@section('content')
    <div class="row align-items-center">
        @if (auth()->user()->is_admin)
            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('admins.index') }}"
                        class="squircle bg-danger justify-content-center text-decoration-none">
                        <i class="fe fe-users fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('admins.index') }}" class="text-decoration-none">
                    <p>Admins</p>
                </a>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('doctors.index') }}"
                        class="squircle bg-success justify-content-center text-decoration-none">
                        <i class="fe fe-users fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('doctors.index') }}" class="text-decoration-none">
                    <p>Dentists</p>
                </a>
            </div>
            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('staff.index') }}"
                        class="squircle bg-primary justify-content-center text-decoration-none">
                        <i class="fe fe-users fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('staff.index') }}" class="text-decoration-none">
                    <p>Reception</p>
                </a>
            </div>

            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('assistants.index') }}"
                        class="squircle bg-staff justify-content-center text-decoration-none">
                        <i class="fe fe-users fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('assistants.index') }}" class="text-decoration-none">
                    <p>Staff</p>
                </a>
            </div>

            <div class="col-6 col-md-3 text-center">
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
            <div class="col-6 col-md-3 text-center">
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
            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('settings.lab-settings') }}"
                        class="squircle bg-secondary justify-content-center text-decoration-none">
                        <i class="fe fe-filter fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('settings.lab-settings') }}" class="text-decoration-none">
                    <p>Lab Settings</p>
                </a>
            </div>

            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('settings.medicine-settings') }}"
                        class="squircle bg-medicine justify-content-center text-decoration-none">
                        <i class="fe fe-thermometer fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('settings.medicine-settings') }}" class="text-decoration-none">
                    <p>Medicine Settings</p>
                </a>
            </div>

            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('treatment-types.index') }}"
                        class="squircle bg-medicine-type justify-content-center text-decoration-none">
                        <i class="fe fe-database fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('treatment-types.index') }}" class="text-decoration-none">
                    <p>Treatment Plans</p>
                </a>
            </div>

            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('medical-histories.index') }}"
                        class="squircle bg-medical-history justify-content-center text-decoration-none">
                        <i class="fe fe-book-open fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('medical-histories.index') }}" class="text-decoration-none">
                    <p>Medical History</p>
                </a>
            </div>

            <div class="col-6 col-md-3 text-center">
                <div>
                    <a href="{{ route('branches.index') }}"
                        class="squircle bg-branch justify-content-center text-decoration-none">
                        <i class="fe fe-map fe-32 align-self-center text-white"></i>
                    </a>
                </div>
                <a href="{{ route('branches.index') }}" class="text-decoration-none">
                    <p>Branches</p>
                </a>
            </div>
        @endif

        <div class="col-6 col-md-3 text-center">
            <div>
                <a href="{{ route('settings.schdule-settings') }}"
                    class="squircle bg-calendar justify-content-center text-decoration-none">
                    <i class="fe fe-calendar fe-32 align-self-center text-white"></i>
                </a>
            </div>
            <a href="{{ route('settings.schdule-settings') }}" class="text-decoration-none">
                <p>Schedule</p>
            </a>
        </div>
    </div>
@endsection
