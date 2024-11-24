@extends('layouts.main-layout')

@section('title', 'Dentist')

@section('page-path-prefix', 'SETTINGS > ')

@section('page-path', 'DENTISTS')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('doctors.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('doctors.update', ['doctor' => $data->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name"
                                    value="{{ old('name') ?? $data->name }}" name="name" dir="auto" disabled>
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="finance">Access Finance</label>
                                <select id="finance" name="finance" class="form-control">
                                    <option {{ $data->finance == 0 ? 'selected' : '' }} value="0">No</option>
                                    <option {{ $data->finance == 1 ? 'selected' : '' }} value="1">Yes</option>
                                </select>
                                @error('finance')
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
