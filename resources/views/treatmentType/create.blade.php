@extends('layouts.main-layout')

@section('title', 'Treatment Type')

@section('buttons')
    <a href="{{ route('treatment-types.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('treatment-types.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Treatment Name</label>
                                <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                    name="name" dir="auto">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="need_labs">Need Labs?</label>
                            <select id="need_labs" name="need_labs" class="form-control">
                                <option value="1" {{ old('need_labs') ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !old('need_labs') ? 'selected' : '' }}>No</option>
                            </select>
                            @error('need_labs')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="multi-select">Diagnosis</label>
                                <select multiple name="diagnosis_ids[]" class="form-control select2-multi"
                                    id="multi-select">
                                    @foreach ($data->diagnosis as $diagnosis)
                                        <option value="{{ $diagnosis->id }}">{{ $diagnosis->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('diagnosis_ids')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description (optional)</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <h4 class="mb-3">Sections</h4>
                            <div id="sections-container">
                                <div class="section mb-5">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="sections[0][title]">Section Title</label>
                                            <input type="text" class="form-control" id="sections[0][title]"
                                                name="sections[0][title]" value="{{ old('sections.0.title') }}">
                                            @error('sections.0.title')
                                                <p style="color: red">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="sections[0][multi_selection]">Multi Selection</label>
                                            <select id="sections[0][multi_selection]" name="sections[0][multi_selection]"
                                                class="form-control">
                                                <option value="1"
                                                    {{ old('sections.0.multi_selection') ? 'selected' : '' }}>Yes</option>
                                                <option value="0"
                                                    {{ !old('sections.0.multi_selection') ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('sections.0.multi_selection')
                                                <p style="color: red">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5 class="mb-3">Attributes</h5>
                                        <div id="attributes-container-0">
                                            <div class="attribute mb-5">
                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label for="sections[0][attributes][0][name]">Attribute Name</label>
                                                        <input type="text" class="form-control"
                                                            name="sections[0][attributes][0][name]"
                                                            placeholder="Attribute Name"
                                                            value="{{ old('sections.0.attributes.0.name') }}">
                                                        @error('sections.0.attributes.0.name')
                                                            <p style="color: red">* {{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Inputs</h6>
                                                    <div id="inputs-container-0-0">

                                                    </div>
                                                    <button type="button" data-attribute="0" data-section="0"
                                                        data-input="0" class="add-input-btn btn btn-info">Add
                                                        Input</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-attribute="1" data-section="0"
                                            class="add-attribute-btn btn btn-dark">Add Another
                                            Attribute</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" data-section="1" class="add-section-btn btn btn-warning mb-2">Add Another
                                Section</button>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', ".add-section-btn", function() {
            const section = $(this).data('section');
            $("#sections-container").append(
                `<div class="section mb-5">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sections[${section}][title]">Section Title</label>
                            <input type="text" class="form-control" id="sections[${section}][title]"
                                name="sections[${section}][title]" value="{{ old('sections.${section}.title') }}">
                            @error('sections.${section}.title')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sections[${section}][multi_selection]">Multi Selection</label>
                            <select id="sections[${section}][multi_selection]" name="sections[${section}][multi_selection]"
                                class="form-control">
                                <option value="1"
                                    {{ old('sections.${section}.multi_selection') ? 'selected' : '' }}>Yes</option>
                                <option value="0"
                                    {{ !old('sections.${section}.multi_selection') ? 'selected' : '' }}>No</option>
                            </select>
                            @error('sections.${section}.multi_selection')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="mb-3">Attributes</h5>
                        <div id="attributes-container-${section}">
                            <div class="attribute mb-5">
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="sections[${section}][attributes][0][name]">Attribute Name</label>
                                        <input type="text" class="form-control"
                                            name="sections[${section}][attributes][0][name]"
                                            placeholder="Attribute Name"
                                            value="{{ old('sections.${section}.attributes.0.name') }}">
                                        @error('sections.${section}.attributes.0.name')
                                            <p style="color: red">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h6>Inputs</h6>
                                    <div id="inputs-container-${section}-0">

                                    </div>
                                    <button type="button" data-attribute="0" data-section="${section}"
                                        data-input="0" class="add-input-btn btn btn-info">Add
                                        Input</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" data-attribute="1" data-section="${section}"
                            class="add-attribute-btn btn btn-dark">Add Another
                            Attribute</button>
                             <button type="button"
                            class="delete-section-btn btn btn-danger">Remove Section</button>
                    </div>
                </div>`);

            $(this).data("section", section + 1);
        })

        $(document).on("click", ".add-attribute-btn", function() {
            const attribute = $(this).data('attribute');
            const section = $(this).data('section');
            $("#attributes-container-" + section).append(`<div class="attribute mb-5">
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="sections[${section}][attributes][${attribute}][name]">Attribute Name</label>
                                                    <input type="text" class="form-control"
                                                        name="sections[${section}][attributes][${attribute}][name]" placeholder="Attribute Name"
                                                        value="{{ old('sections.${section}.attributes.${attribute}.name') }}">
                                                    @error('sections.${section}.attributes.${attribute}.name')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <h6>Inputs</h6>
                                                <div id="inputs-container-${section}-${attribute}">

                                                </div>
                                                <button type="button" data-attribute="${attribute}" data-section="${section}" data-input="0"
                                                    class="add-input-btn btn btn-info">Add
                                                    Input</button>

                                                    <button type="button" class="delete-attribute-btn btn btn-danger">Remove Attribute</button>
                                            </div>
                                        </div>`);
            $(this).data("attribute", attribute + 1);
        })

        $(document).on('click', ".add-input-btn", function() {
            const attribute = $(this).data('attribute');
            const section = $(this).data('section');
            const input = $(this).data('input');
            $("#inputs-container-" + section + "-" + attribute).append(`<div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="sections[${section}][attributes][${attribute}][inputs][${input}][name]">Input Name</label>
                                <input type="text" class="form-control"
                                    name="sections[${section}][attributes][${attribute}][inputs][${input}][name]"
                                    value="{{ old('sections.${section}.attributes.${attribute}.inputs.${input}.name') }}">
                                @error('sections.${section}.attributes.${attribute}.inputs.${input}.name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label for="sections[${section}][attributes][${attribute}][inputs][${input}][value]">Input Value
                                    (optional)</label>
                                <input type="text" class="form-control"
                                    name="sections[${section}][attributes][${attribute}][inputs][${input}][value]"
                                    value="{{ old('sections.${section}.attributes.${attribute}.inputs.${input}.value') }}">
                                @error('sections.${section}.attributes.${attribute}.inputs.${input}.value')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="button"
                                    class="btn btn-danger btn-sm delete-input-btn">Remove Input</button>
                            </div>
                        </div>`);

            $(this).data("input", input + 1);
        })

        $(document).on('click', ".delete-input-btn", function() {
            $(this).closest('.form-row').remove();
        })

        $(document).on('click', ".delete-attribute-btn", function() {
            $(this).closest('.attribute').remove();
        })

        $(document).on('click', ".delete-section-btn", function() {
            $(this).closest('.section').remove();
        })
    </script>

@endsection
