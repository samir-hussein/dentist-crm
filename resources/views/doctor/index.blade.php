@extends('layouts.main-layout')

@section('title', 'Doctor')

@section('buttons')
    <button type="button" class="btn btn-primary"><span class="fe fe-plus fe-12 mr-2"></span>Create</button>
@endsection

@section('content')
    <div class="row">
        @for ($i = 0; $i < 12; $i++)
            <div class="col-md-3">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <div class="avatar avatar-lg mt-4">
                            <a href="">
                                <img src="./assets/avatars/face-4.jpg" alt="..." class="avatar-img rounded-circle">
                            </a>
                        </div>
                        <div class="card-text my-2">
                            <strong class="card-title my-0">Bass Wendy </strong>
                            <p class="text-muted mb-0">Female</p>
                            <p><span class="badge badge-light text-muted">01144435326</span></p>
                        </div>
                    </div> <!-- ./card-text -->
                    <div class="card-footer">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <a href=""><button class="btn btn-sm btn-info">Profile</button></a>
                            </div>
                            <div class="col-auto">
                                <a href=""><button class="btn btn-sm btn-danger">Delete</button></a>
                            </div>
                        </div>
                    </div> <!-- /.card-footer -->
                </div>
            </div> <!-- .col -->
        @endfor
    </div> <!-- .row -->
@endsection
