@extends('layouts.main-layout')

@section('title', 'Medicines')

@section('page-path-prefix', 'SETTINGS >> MEDICINE SETTINGS >> ')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('medicines.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('medicines.update', ['medicine' => $data->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="simple-select2">Medicine Type</label>
                                <select class="form-control select2" id="simple-select2" name="medicine_type_id">
                                    @foreach ($data->medicineTypes as $type)
                                        <option
                                            {{ (old('medicine_type_id') ?? $data->medicineType->id) == $type->id ? 'selected' : '' }}
                                            value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('medicine_type_id')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div> <!-- form-group -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Medicine Name</label>
                                <input type="text" class="form-control" id="name"
                                    value="{{ old('name') ?? $data->name }}" name="name" dir="auto">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="description">Medicine Description</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="5">{{ old('description') ?? $data->description }}</textarea>
                                @error('description')
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
