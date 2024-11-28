@extends('layouts.main-layout')

@section('style')
    <style>
        a,
        button {
            color: inherit;
            text-decoration: none;
        }
    </style>
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
        <div class="col-12 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="logo" width="200">
        </div> <!-- simple table -->

        <div class="col-12 mt-5">
            <div class="row">
                <div class="col-4 text-center">
                    <div>
                        <a href="{{ route('appointments.index') }}"
                            class="squircle bg-success justify-content-center text-decoration-none">
                            <i class="fe fe-calendar fe-32 align-self-center text-white"></i>
                        </a>
                    </div>
                    <a href="{{ route('appointments.index') }}" class="text-decoration-none">
                        <p>Appointments</p>
                    </a>
                </div>

                <div class="col-4 text-center">
                    <div>
                        <a href="{{ route('patients.index') }}"
                            class="squircle bg-danger justify-content-center text-decoration-none">
                            <i class="fe fe-users fe-32 align-self-center text-white"></i>
                        </a>
                    </div>
                    <a href="{{ route('patients.index') }}" class="text-decoration-none">
                        <p>Patients</p>
                    </a>
                </div>

                <div class="col-4 text-center">
                    <div>
                        <a href="{{ route('assistants.shift') }}"
                            class="squircle bg-info justify-content-center text-decoration-none">
                            <i class="fe fe-file-text fe-32 align-self-center text-white"></i>
                        </a>
                    </div>
                    <a href="{{ route('assistants.shift') }}" class="text-decoration-none">
                        <p>Staff</p>
                    </a>
                </div>

            </div>
        </div>
    </div> <!-- end section -->
@endsection
