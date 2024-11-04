@extends('layouts.main-layout')

@section('title', 'Treatment Type')

@section('page-path-prefix', 'SETTINGS > ')

@section('settings-active', 'active-link')

@section('buttons')
    <a href="{{ route('treatment-types.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('style')
    <style>
        .tooth-chart {
            width: 150px;
        }

        .Spots {

            polygon,
            path {
                -webkit-transition: fill 0.25s;
                transition: fill 0.25s;
            }

            polygon:hover,
            polygon:active,
            path:hover,
            path:active {
                fill: #c0bfbf !important;
                cursor: pointer;
            }

            .selected {
                fill: #ffcc00 !important;
            }
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
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('treatment-types.update', ['treatment_type' => $data->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="multi-select">Diagnosis</label>
                                <select multiple name="diagnosis_ids[]" class="form-control select2-multi"
                                    id="multi-select">
                                    @foreach ($data->diagnosis as $diagnosis)
                                        <option {{ in_array($diagnosis->id, $data->selected_diagnosis) ? 'selected' : '' }}
                                            value="{{ $diagnosis->id }}">{{ $diagnosis->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('diagnosis_ids')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Treatment Name</label>
                                <input type="text" class="form-control" id="name"
                                    value="{{ old('name') ?? $data->name }}" name="name" dir="auto">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="need_labs">Need Labs?</label>
                            <select id="need_labs" name="need_labs" class="form-control">
                                <option value="1" {{ old('need_labs') || $data->need_labs ? 'selected' : '' }}>Yes
                                </option>
                                <option {{ !$data->need_labs ? 'selected' : '' }} value="0">No</option>
                            </select>
                            @error('need_labs')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description (optional)</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description') ?? $data->description }}</textarea>
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
                                                name="sections[0][title]"
                                                value="{{ old('sections.0.title') ?? $data->sections[0]->title }}">
                                            @error('sections.0.title')
                                                <p style="color: red">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="sections[0][multi_selection]">Multi Selection</label>
                                            <select id="sections[0][multi_selection]" name="sections[0][multi_selection]"
                                                class="form-control">
                                                <option value="1"
                                                    {{ old('sections.0.multi_selection') || $data->sections[0]->multi_selection ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="0"
                                                    {{ !$data->sections[0]->multi_selection ? 'selected' : '' }}>
                                                    No</option>
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
                                                            value="{{ old('sections.0.attributes.0.name') ?? $data->sections[0]->attributes[0]->name }}">
                                                        @error('sections.0.attributes.0.name')
                                                            <p style="color: red">* {{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Inputs</h6>
                                                    <div id="inputs-container-0-0">
                                                        @if ($data->sections[0]->attributes[0]->inputs)
                                                            @for ($i = 0; $i < count($data->sections[0]->attributes[0]->inputs); $i++)
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-11">
                                                                        <label
                                                                            for="sections[0][attributes][0][inputs][{{ $i }}][name]">Input
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="sections[0][attributes][0][inputs][{{ $i }}][name]"
                                                                            value="{{ old('sections.0.attributes.0.inputs.' . $i . '.name') ?? $data->sections[0]->attributes[0]->inputs[$i]->name }}">
                                                                        @error("sections.0.attributes.0.inputs.$i.name")
                                                                            <p style="color: red">* {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-1 d-flex align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm delete-input-btn">X</button>
                                                                    </div>
                                                                    <div class="form-group col-12 col-md-6">
                                                                        <label for="tooths">Adult Tooths</label>
                                                                        <x-tooth-chart
                                                                            nameAttr="sections[0][attributes][0][inputs][{{ $i }}][adultTooths]"
                                                                            :selectedteeth="json_encode(
                                                                                $data->sections[0]->attributes[0]
                                                                                    ->inputs[$i]->adultTooths,
                                                                            )" />
                                                                    </div>

                                                                    <div class="form-group col-12 col-md-6">
                                                                        <label for="tooths">Child Tooths</label>
                                                                        <x-child-tooth-chart
                                                                            nameAttr="sections[0][attributes][0][inputs][{{ $i }}][childTooths]"
                                                                            :selectedteeth="json_encode(
                                                                                $data->sections[0]->attributes[0]
                                                                                    ->inputs[$i]->childTooths,
                                                                            )" />
                                                                    </div>
                                                                </div>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                    <button type="button" data-attribute="0" data-section="0"
                                                        data-input="{{ $i }}"
                                                        class="add-input-btn btn btn-info">Add
                                                        Input</button>
                                                </div>
                                            </div>

                                            @if (count($data->sections[0]->attributes) > 0)
                                                @for ($a = 1; $a < count($data->sections[0]->attributes); $a++)
                                                    <div class="attribute mb-5">
                                                        <div class="form-row">
                                                            <div class="form-group col-12">
                                                                <label
                                                                    for="sections[0][attributes][{{ $a }}][name]">Attribute
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="sections[0][attributes][{{ $a }}][name]"
                                                                    placeholder="Attribute Name"
                                                                    value="{{ old('sections.0.attributes.' . $a . '.name') ?? $data->sections[0]->attributes[$a]->name }}">
                                                                @error('sections.0.attributes.' . $a . '.name')
                                                                    <p style="color: red">* {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h6>Inputs</h6>
                                                            <div id="inputs-container-0-{{ $a }}">
                                                                @if ($data->sections[0]->attributes[$a]->inputs)
                                                                    @for ($i = 0; $i < count($data->sections[0]->attributes[$a]->inputs); $i++)
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-11">
                                                                                <label
                                                                                    for="sections[0][attributes][{{ $a }}][inputs][{{ $i }}][name]">Input
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="sections[0][attributes][{{ $a }}][inputs][{{ $i }}][name]"
                                                                                    value="{{ old('sections.0.attributes.' . $a . '.inputs.' . $i . '.name') ?? $data->sections[0]->attributes[$a]->inputs[$i]->name }}">
                                                                                @error("sections.0.attributes.$a.inputs.$i.name")
                                                                                    <p style="color: red">*
                                                                                        {{ $message }}</p>
                                                                                @enderror
                                                                            </div>

                                                                            <div
                                                                                class="col-md-1 d-flex align-items-center">
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm delete-input-btn">X</button>
                                                                            </div>

                                                                            <div class="form-group col-12 col-md-6">
                                                                                <label for="tooths">Adult Tooths</label>
                                                                                <x-tooth-chart
                                                                                    nameAttr="sections[0][attributes][{{ $a }}][inputs][{{ $i }}][adultTooths]"
                                                                                    :selectedteeth="json_encode(
                                                                                        $data->sections[0]->attributes[
                                                                                            $a
                                                                                        ]->inputs[$i]->adultTooths,
                                                                                    )" />
                                                                            </div>

                                                                            <div class="form-group col-12 col-md-6">
                                                                                <label for="tooths">Child Tooths</label>
                                                                                <x-child-tooth-chart
                                                                                    nameAttr="sections[0][attributes][{{ $a }}][inputs][{{ $i }}][childTooths]"
                                                                                    :selectedteeth="json_encode(
                                                                                        $data->sections[0]->attributes[
                                                                                            $a
                                                                                        ]->inputs[$i]->childTooths,
                                                                                    )" />
                                                                            </div>
                                                                        </div>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                            <button type="button" data-attribute="{{ $a }}"
                                                                data-section="0" data-input="{{ $i }}"
                                                                class="add-input-btn btn btn-info">Add
                                                                Input</button>
                                                            <button type="button"
                                                                class="delete-attribute-btn btn btn-danger">Remove
                                                                Attribute</button>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                        <button type="button" data-attribute="{{ $a }}" data-section="0"
                                            class="add-attribute-btn btn btn-dark">Add Another
                                            Attribute</button>
                                    </div>
                                </div>

                                @if (count($data->sections) > 0)
                                    @for ($i = 1; $i < count($data->sections); $i++)
                                        <div class="section mb-5">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="sections[{{ $i }}][title]">Section
                                                        Title</label>
                                                    <input type="text" class="form-control"
                                                        id="sections[{{ $i }}][title]"
                                                        name="sections[{{ $i }}][title]"
                                                        value="{{ old('sections.' . $i . '.title') ?? $data->sections[$i]->title }}">
                                                    @error("sections.$i.title")
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sections[{{ $i }}][multi_selection]">Multi
                                                        Selection</label>
                                                    <select id="sections[{{ $i }}][multi_selection]"
                                                        name="sections[{{ $i }}][multi_selection]"
                                                        class="form-control">
                                                        <option value="1"
                                                            {{ old('sections.' . $i . '.multi_selection') || $data->sections[$i]->multi_selection ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="0"
                                                            {{ !$data->sections[$i]->multi_selection ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                    @error("sections.$i.multi_selection")
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <h5 class="mb-3">Attributes</h5>
                                                <div id="attributes-container-{{ $i }}">
                                                    <div class="attribute mb-5">
                                                        <div class="form-row">
                                                            <div class="form-group col-12">
                                                                <label
                                                                    for="sections[{{ $i }}][attributes][0][name]">Attribute
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="sections[{{ $i }}][attributes][0][name]"
                                                                    placeholder="Attribute Name"
                                                                    value="{{ old('sections.' . $i . '.attributes.0.name') ?? $data->sections[$i]->attributes[0]->name }}">
                                                                @error('sections.' . $i . '.attributes.0.name')
                                                                    <p style="color: red">* {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h6>Inputs</h6>
                                                            <div id="inputs-container-{{ $i }}-0">
                                                                @if ($data->sections[$i]->attributes[0]->inputs)
                                                                    @for ($j = 0; $j < count($data->sections[$i]->attributes[0]->inputs); $j++)
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-11">
                                                                                <label
                                                                                    for="sections[{{ $i }}][attributes][0][inputs][{{ $j }}][name]">Input
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="sections[{{ $i }}][attributes][0][inputs][{{ $j }}][name]"
                                                                                    value="{{ old('sections.' . $i . '.attributes.0.inputs.' . $j . '.name') ?? $data->sections[$i]->attributes[0]->inputs[$j]->name }}">
                                                                                @error("sections.$i.attributes.0.inputs.$j.name")
                                                                                    <p style="color: red">*
                                                                                        {{ $message }}</p>
                                                                                @enderror
                                                                            </div>

                                                                            <div
                                                                                class="col-md-1 d-flex align-items-center">
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm delete-input-btn">X</button>
                                                                            </div>

                                                                            <div class="form-group col-12 col-md-6">
                                                                                <label for="tooths">Adult Tooths</label>
                                                                                <x-tooth-chart
                                                                                    nameAttr="sections[{{ $i }}][attributes][0][inputs][{{ $j }}][adultTooths]"
                                                                                    :selectedteeth="json_encode(
                                                                                        $data->sections[$i]
                                                                                            ->attributes[0]->inputs[$j]
                                                                                            ->adultTooths,
                                                                                    )" />
                                                                            </div>

                                                                            <div class="form-group col-12 col-md-6">
                                                                                <label for="tooths">Child Tooths</label>
                                                                                <x-child-tooth-chart
                                                                                    nameAttr="sections[{{ $i }}][attributes][0][inputs][{{ $j }}][childTooths]"
                                                                                    :selectedteeth="json_encode(
                                                                                        $data->sections[$i]
                                                                                            ->attributes[0]->inputs[$j]
                                                                                            ->childTooths,
                                                                                    )" />
                                                                            </div>
                                                                        </div>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                            <button type="button" data-attribute="0"
                                                                data-section="{{ $i }}"
                                                                data-input="{{ $j }}"
                                                                class="add-input-btn btn btn-info">Add
                                                                Input</button>
                                                        </div>
                                                    </div>

                                                    @if (count($data->sections[$i]->attributes) > 0)
                                                        @for ($a = 1; $a < count($data->sections[$i]->attributes); $a++)
                                                            <div class="attribute mb-5">
                                                                <div class="form-row">
                                                                    <div class="form-group col-12">
                                                                        <label
                                                                            for="sections[{{ $i }}][attributes][{{ $a }}][name]">Attribute
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="sections[{{ $i }}][attributes][{{ $a }}][name]"
                                                                            placeholder="Attribute Name"
                                                                            value="{{ old('sections.' . $i . '.attributes.' . $a . '.name') ?? $data->sections[$i]->attributes[$a]->name }}">
                                                                        @error('sections.' . $i . '.attributes.' . $a .
                                                                            '.name')
                                                                            <p style="color: red">* {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <h6>Inputs</h6>
                                                                    <div
                                                                        id="inputs-container-{{ $i }}-{{ $a }}">
                                                                        @if ($data->sections[$i]->attributes[$a]->inputs)
                                                                            @for ($j = 0; $j < count($data->sections[$i]->attributes[$a]->inputs); $j++)
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-11">
                                                                                        <label
                                                                                            for="sections[{{ $i }}][attributes][{{ $a }}][inputs][{{ $j }}][name]">Input
                                                                                            Name</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="sections[{{ $i }}][attributes][{{ $a }}][inputs][{{ $j }}][name]"
                                                                                            value="{{ old('sections.' . $i . '.attributes.' . $a . '.inputs.' . $j . '.name') ?? $data->sections[$i]->attributes[$a]->inputs[$j]->name }}">
                                                                                        @error("sections.$i.attributes.$a.inputs.$j.name")
                                                                                            <p style="color: red">*
                                                                                                {{ $message }}</p>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-1 d-flex align-items-center">
                                                                                        <button type="button"
                                                                                            class="btn btn-danger btn-sm delete-input-btn">X</button>
                                                                                    </div>

                                                                                    <div
                                                                                        class="form-group col-12 col-md-6">
                                                                                        <label for="tooths">Adult
                                                                                            Tooths</label>
                                                                                        <x-tooth-chart
                                                                                            nameAttr="sections[{{ $i }}][attributes][{{ $a }}][inputs][{{ $j }}][adultTooths]"
                                                                                            :selectedteeth="json_encode(
                                                                                                $data->sections[$i]
                                                                                                    ->attributes[$a]
                                                                                                    ->inputs[$j]
                                                                                                    ->adultTooths,
                                                                                            )" />
                                                                                    </div>

                                                                                    <div
                                                                                        class="form-group col-12 col-md-6">
                                                                                        <label for="tooths">Child
                                                                                            Tooths</label>
                                                                                        <x-child-tooth-chart
                                                                                            nameAttr="sections[{{ $i }}][attributes][{{ $a }}][inputs][{{ $j }}][childTooths]"
                                                                                            :selectedteeth="json_encode(
                                                                                                $data->sections[$i]
                                                                                                    ->attributes[$a]
                                                                                                    ->inputs[$j]
                                                                                                    ->childTooths,
                                                                                            )" />
                                                                                    </div>
                                                                                </div>
                                                                            @endfor
                                                                        @endif
                                                                    </div>
                                                                    <button type="button"
                                                                        data-attribute="{{ $a }}"
                                                                        data-section="{{ $i }}"
                                                                        data-input="{{ $j }}"
                                                                        class="add-input-btn btn btn-info">Add
                                                                        Input</button>
                                                                    <button type="button"
                                                                        class="delete-attribute-btn btn btn-danger">Remove
                                                                        Attribute</button>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    @endif
                                                </div>
                                                <button type="button" data-attribute="{{ $a }}"
                                                    data-section="{{ $i }}"
                                                    class="add-attribute-btn btn btn-dark">Add Another
                                                    Attribute</button>
                                                <button type="button" class="delete-section-btn btn btn-danger">Remove
                                                    Section</button>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <button type="button" data-section="{{ $i }}"
                                class="add-section-btn btn btn-warning mb-2">Add
                                Another
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
            $("#inputs-container-" + section + "-" + attribute).append(`
                <div class="form-row">
                    <div class="form-group col-md-11">
                        <label for="sections[${section}][attributes][${attribute}][inputs][${input}][name]">Input Name</label>
                        <input type="text" class="form-control"
                            name="sections[${section}][attributes][${attribute}][inputs][${input}][name]"
                            value="{{ old('sections.${section}.attributes.${attribute}.inputs.${input}.name') }}">
                        @error('sections.${section}.attributes.${attribute}.inputs.${input}.name')
                            <p style="color: red">* {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button"
                            class="btn btn-danger btn-sm delete-input-btn">X</button>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="tooths">Adult Tooths</label>
                        <x-tooth-chart nameAttr="sections[${section}][attributes][${attribute}][inputs][${input}][adultTooths]"/>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="tooths">Child Tooths</label>
                        <x-child-tooth-chart nameAttr="sections[${section}][attributes][${attribute}][inputs][${input}][childTooths]"/>
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

    <script>
        $(document).ready(function() {
            // Event listener for selecting/deselecting a tooth
            $(document).on("click", "polygon, path", function() {
                const toothNumber = $(this).data("key"); // Get the data-key attribute (tooth number)
                const toothType = $(this).data("tooth");

                // Ensure the toothNumber is defined before processing
                if (toothNumber !== undefined) {
                    let closestToothChart = $(this).closest('.tooth-chart');

                    // Get or initialize the array of selected teeth for this specific chart
                    let selectedTeeth = closestToothChart.data('selectedteeth') || [];

                    if ($(this).hasClass("selected")) {
                        // If the tooth is already selected, remove it from the array
                        selectedTeeth = selectedTeeth.filter(t => t != toothNumber);
                    } else {
                        // If it's not selected, add it to the array
                        selectedTeeth.push(toothNumber);
                    }

                    // Update the data-tooth attribute in the closestToothChart to store the updated array
                    closestToothChart.data('selectedteeth', selectedTeeth);

                    // Toggle the selected class to change the color
                    $(this).toggleClass("selected");

                    updateInput(closestToothChart, selectedTeeth);
                }
            });

            // Function to mark selected teeth based on the data-selectedTeeth attribute
            $('.tooth-chart').each(function() {
                const closestToothChart = $(this);
                const selectedTeeth = closestToothChart.data('selectedteeth') || [];

                // Mark the selected teeth based on the selectedTeeth array
                selectedTeeth.forEach(tooth => {
                    closestToothChart.find(
                        `polygon[data-key='${tooth}'], path[data-key='${tooth}']`).addClass(
                        'selected');
                });

                updateInput(closestToothChart, selectedTeeth);
            });

            function updateInput(closestToothChart, selectedTeeth) {
                let dataId = closestToothChart.data("id");

                const closestHiddenInputs = closestToothChart.prev('.hidden-tooth-inputs');

                // Clear the closest hidden inputs container
                closestHiddenInputs.empty();

                // Append hidden inputs for the selected teeth
                selectedTeeth.forEach(tooth => {
                    closestHiddenInputs.append(
                        `<input type="hidden" name="${dataId}[]" value="${tooth}">`
                    );
                });
            }
        });
    </script>

@endsection
