@extends('layouts.main-layout')

@section('title', 'Diagnosis')

@section('page-path-prefix', 'SETTINGS >> ')

@section('buttons')
    <a href="{{ route('diagnosis.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('diagnosis.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Diagnosis Name</label>
                                <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                    name="name" dir="auto">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Description (optional)</label>
                            <textarea class="form-control" dir="auto" name="description" id="" cols="30" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection
