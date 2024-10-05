@extends('layouts.main-layout')

@section('title', 'Admins')

@section('buttons')
    <a href="{{ route('admins.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admins.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                    name="name" dir="auto">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ old('email') }}"
                                    name="email" dir="auto">
                                @error('email')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" value="{{ old('password') }}"
                                    name="password" dir="auto">
                                @error('password')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    value="{{ old('password_confirmation') }}" name="password_confirmation" dir="auto">
                                @error('password_confirmation')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection
