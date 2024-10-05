@extends('layouts.main-layout')

@section('title', 'Patients')

@section('buttons')
    <a href="{{ route('patients.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('patients.store') }}" method="post">
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
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" value="{{ old('address') }}"
                                name="address">
                            @error('address')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" value="{{ old('age') }}"
                                    name="age">
                                @error('age')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                @error('gender')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" value="{{ old('phone') }}"
                                    name="phone">
                                @error('phone')
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
