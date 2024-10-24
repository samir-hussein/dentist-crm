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
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('treatment-types.store') }}" method="post">
                        @csrf
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
                            <div class="form-group col-12 col-md-6">
                            <label for="tooths">Adult Tooths</label>
                            <div class="hidden-tooth-inputs" data-tooth=""></div>
                            @error('tooths')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                            <div class="tooth-chart" data-id="sections[${section}][attributes][${attribute}][inputs][${input}][adultTooths]">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 450 700"
                                    enable-background="new 0 0 450 700" xml:space="preserve">
                                    <g class="Spots">
                                        <polygon id="Tooth32" fill="#FFFFFF" data-tooth="adult" data-key="32"
                                            points="66.7,369.7 59,370.3 51,373.7 43.7,384.3 42.3,392 38.7,406 41,415.3 44.3,420.3
                                        47.3,424 51.7,424.3 57.7,424 62.3,422.7 66.7,422.7 71,424.3 76.3,422.7 80.7,419.3 84.7,412.3 85.3,405 87.3,391.7 85,380
                                        80.7,375 73.7,371.3 	" />
                                        <polygon id="Tooth31" fill="#FFFFFF" data-tooth="adult" data-key="31"
                                            points="76,425.7 80.3,427.7 83.3,433 85.3,447.7 84.3,458.7 79.7,472.3 73,475 50.3,479.7
                                        46.7,476.7 37.7,446.3 39.7,438.3 43.3,432 49,426.7 56,424.7 65,424.7 	" />
                                        <polygon id="Tooth30" fill="#FFFFFF" data-tooth="adult" data-key="30"
                                            points="78.7,476 85,481 90.3,488.3 96.3,499.3 97.7,511.3 93,522 86,526.3 67,533
                                        60.3,529.7 56.3,523.7 51.7,511 47.7,494.7 47.7,488.3 50.3,483.3 55,479.7 67,476.7 	" />
                                        <polygon id="Tooth29" fill="#FFFFFF" data-tooth="adult" data-key="29"
                                            points="93.3,525 99.3,527.3 108.3,536 114,546.7 115.7,559.3 114.3,567.3 106.3,573
                                        98.3,578.3 88,579 82,575 75,565 69.3,552.3 67.3,542 69.7,536 74.3,531.7 84.3,528.3 	" />
                                        <path id="Tooth28" fill="#FFFFFF" data-tooth="adult" data-key="28"
                                            d="M117.3,569.7l7.7,1.3l6.3,3.7l6.3,7.7l4,8.3L144,602l-1.3,6.7l-6.7,6.7l-7.7,3.3l-7.3-1l-7-3
                                                                                                                                                            l-7.3-7l-5-9l-2-10c0,0-0.7-7,0.3-7.3c1-0.3,5.3-6.7,5.3-6.7l9-5H117.3z" />
                                        <polygon id="Tooth27" fill="#FFFFFF" data-tooth="adult" data-key="27"
                                            points="155.7,611 160.3,615.3 165,624.7 161.7,634.3 156,641.3 149,644 140.7,644.3
                                        133.3,641.3 128.7,634.7 128.7,629 132.7,621.3 137.7,615 143.7,611 149.7,610 	" />
                                        <polygon id="Tooth26" fill="#FFFFFF" data-tooth="adult" data-key="26"
                                            points="178.3,627 186,629 187.7,633.7 188.7,644 189,657 189.3,662.7 186.3,663.7 176.7,663
                                        168,656.3 159.3,649.7 156.7,644 162,639.3 	" />
                                        <polygon id="Tooth25" fill="#FFFFFF" data-tooth="adult" data-key="25"
                                            points="214,637 218,642.7 223,654.3 225.7,664 225.3,666.3 219,668.3 206.7,668 196,665.7
                                        190.3,662.7 193,657.3 199.7,647.3 207,638 210.7,635.5 	" />
                                        <path id="Tooth24" fill="#FFFFFF" data-tooth="adult" data-key="24"
                                            d="M235.3,637c0,0,3-2,4-2.3c1-0.3,4.3,0,4.3,0l5,4.3l5.3,7.3l3.3,6.7l2,7.3l-2,3l-7.7,2.7
                                                                                                                                                            l-10,0.3h-10l-2-6.7l2.7-7.3L235.3,637z" />
                                        <polygon id="Tooth23" fill="#FFFFFF" data-tooth="adult" data-key="23"
                                            points="269.3,624 273.3,624.7 275.3,627.3 279,628.7 281.7,631.3 285.3,634.7 289.3,638.3
                                        292,643.3 291.3,650 287,655 280.7,658.7 272,660 265,660.7 261.3,657.3 261.7,650 263.7,637 264.3,627 	" />
                                        <polygon id="Tooth22" fill="#FFFFFF" data-tooth="adult" data-key="22"
                                            points="286,629.3 286.7,633.3 291.3,638.7 295.3,642.3 302,644 311.7,643.3 318.3,637.7
                                        321,630 321.3,620.3 317,614.3 308,608 298.3,607 291,609.3 287,612.3 286.7,617.7 287.3,624.7 	" />
                                        <polygon id="Tooth21" fill="#FFFFFF" data-tooth="adult" data-key="21"
                                            points="331,565.7 335,565.7 341.3,568 349.3,574.3 352.3,578.3 352.7,583.7 350.7,593.7
                                        342.7,604 337.7,609 328,612.7 320,613.3 315,611 308.3,604.7 306.7,598 307.3,591.3 309,584.7 312.7,578.3 318.3,571.7 	" />
                                        <polygon id="Tooth20" fill="#FFFFFF" data-tooth="adult" data-key="20"
                                            points="334,561 338.7,566 346,570 354.7,573 360.7,571.7 368,568.3 383,545 385.3,532.7
                                        381.3,524.3 374,520.7 363.7,516.3 356.3,515.3 351.3,518.3 346.3,524 340.3,534.3 336,546.7 	" />
                                        <path id="Tooth19" fill="#FFFFFF" data-tooth="adult" data-key="19"
                                            d="M398,470l4.7,5.7l3,7.7l-0.3,11.7l-6,13.3l-6.3,10.3l-8.3,4.3l-7.3-1l-16.3-7c0,0-2.7-6-3-7.3
                                                                                                                                                            c-0.3-1.3-0.3-11-0.3-11l3.7-14.3l3.7-7l5.3-6.7l8-2l9.7-0.7L398,470z" />
                                        <polygon id="Tooth18" fill="#FFFFFF" data-tooth="adult" data-key="18"
                                            points="410,435 408.7,447.3 404.3,459 399.3,467.7 393.7,468 388,466 376.3,466.3
                                        369.7,466.3 365.7,460 364.7,444.7 366.3,434.3 369,424 378.3,417.3 386.7,415.7 391.7,415.3 396,418 399.7,418 404,421.7
                                        407.7,427.3 	" />
                                        <polygon id="Tooth17" fill="#FFFFFF" data-tooth="adult" data-key="17"
                                            points="371.7,417 378.3,417.3 386.7,415.7 391.7,415.3 397.3,417.7 402.7,416.3 407.7,409.7
                                        406.7,395 401,377.7 397.3,373 390.7,367.3 380,365 373,366.7 367.3,369 364,374.3 360,389 363.3,401.3 367.7,412.3 	" />
                                        <polygon id="Tooth16" fill="#FFFFFF" data-tooth="adult" data-key="16"
                                            points="404.3,293.7 408.7,299.3 408.7,308 405.3,318.7 401,329.7 392.3,339.7 382.7,341
                                        369,339.7 359,335 354.7,327.7 354.3,316 358.3,304 363.7,294 368.7,294.7 378.7,296 389,296 	" />
                                        <polygon id="Tooth15" fill="#FFFFFF" data-tooth="adult" data-key="15"
                                            points="362.3,247.3 357.3,251 357,259.3 358.7,268 359.7,279.7 361.3,286.7 365,291.7
                                        371,294.3 392,295 404.3,293.7 410,280.7 412,263.3 407.3,246.7 401,240.3 396,239.7 389.3,243 	" />
                                        <polygon id="Tooth14" fill="#FFFFFF" data-tooth="adult" data-key="14"
                                            points="359.7,243.7 350.7,224 345.7,211.7 348.7,205 358.3,202.7 375.7,197 388.7,193
                                        393,196 399.3,207 401.3,222.7 400,234.3 394.7,240.7 381.7,244.7 371,246 	" />
                                        <polygon id="Tooth13" fill="#FFFFFF" data-tooth="adult" data-key="13"
                                            points="386,188.7 383.3,192.7 377.7,196 356.3,203.3 345.7,202.3 341.7,199.7 338.7,196.3
                                        335,188.7 332,177 333.7,169.7 338,164.7 346.3,161 353.7,156.7 360.3,150.3 364,151 370.7,156.3 376.3,164.3 380,170.3
                                        383.3,178.3 	" />
                                        <polygon id="Tooth12" fill="#FFFFFF" data-tooth="adult" data-key="12"
                                            points="358.7,134.3 360.3,145.7 357.3,152.7 352,157.3 346.3,161 336,164 329.7,163.3
                                        321.7,157.7 314.3,149 310.7,139.3 310,133.7 312.3,127 318.3,125.7 326,122 332.7,116 334.7,114.3 337.7,117.3 343.3,119.7
                                        348.7,122.7 354.3,127.7 	" />
                                        <polygon id="Tooth11" fill="#FFFFFF" data-tooth="adult" data-key="11"
                                            points="336,93.3 337.7,100 336,104.7 332.7,113.7 324.3,121.3 315.3,125.7 306.3,126
                                        297.3,120.3 294,112 295.7,102.7 299,95 303.3,90 309.3,88 316.3,87.3 322.7,87.3 328,88.3 	" />
                                        <polygon id="Tooth10" fill="#FFFFFF" data-tooth="adult" data-key="10"
                                            points="310.3,83.3 298,90.7 286,95 276.3,98.3 270.3,93.3 269,82.7 269,69.3 270,58.7
                                        274.7,54.7 282,53 287.7,54.7 297.3,60.3 304,64.3 308.7,68.7 312.3,74 313,81 	" />
                                        <polygon id="Tooth9" fill="#FFFFFF" data-tooth="adult" data-key="9"
                                            points="273.3,52 266.7,61.7 258.3,72.3 253.3,79.7 247.3,85 239,87.7 232.3,82 224.7,67
                                        222,58.3 219,50 220,44.3 224.3,40.3 230,38.7 237.3,38.7 253,39.3 258.7,41.3 264.3,43.7 268.3,45.7 	" />
                                        <polygon id="Tooth8" fill="#FFFFFF" data-tooth="adult" data-key="8"
                                            points="176.7,46.3 195,41 203.3,39.7 209.3,40.7 215.3,42.7 217,47 217.7,54.3 215,64.7
                                        212.3,75.7 208,83 201.7,85.7 195.7,86.7 189.7,83.3 183.7,74.7 175,62 171.7,54 172.7,49.7 	" />
                                        <path id="Tooth7" fill="#FFFFFF" data-tooth="adult" data-key="7"
                                            d="M167,55l6.7,6.3L174,68l0.3,8l1,10l-2,8.3l-4.7,4.3l-6.7,1.7l-8-4.3l-7.3-4.7l-9.3-4.7
                                                                                                                                                            l-6.3-5.3l-1-4.3l1.3-5c0,0,3.3-6,4.3-6s5.3-6,6.3-6s10.3-4.7,10.3-4.7L167,55z" />
                                        <polygon id="Tooth6" fill="#FFFFFF" data-tooth="adult" data-key="6"
                                            points="126.3,82 134.3,86.3 139.7,92.3 144.7,104.7 145.7,115.3 143.7,120.7 138,124.3
                                        131.3,125 121,125 114.7,119.3 110.3,112.3 108.3,104.7 108.7,94.7 110.7,88.7 116,84 	" />
                                        <polygon id="Tooth5" fill="#FFFFFF" data-tooth="adult" data-key="5"
                                            points="109,116.7 116,122.3 122.7,125.3 127.7,131.3 128.3,141 122.7,153.7 114,161.7
                                        105.7,162.3 96.7,161 85.7,156 82,150 81,139.3 86.3,128 93,121.3 100.7,117.3 	" />
                                        <polygon id="Tooth4" fill="#FFFFFF" data-tooth="adult" data-key="4"
                                            points="82,155.3 102.3,163.3 108.7,172 109.3,182 104.7,192 100,199 94,203.7 85.3,201.7
                                        73.7,201 64.3,196.7 60.3,190.7 59,183.3 61.7,175.3 66.3,167.7 71.3,161.3 	" />
                                        <path id="Tooth3" fill="#FFFFFF" data-tooth="adult" data-key="3"
                                            d="M92.7,207.3l2,5.3l-1.7,8l-1.7,9l-4,8l-5,7.7l-11,4.7l-13.7,0.7l-10-7l-1.7-5L45,220l3-10.7
                                                                                                                                                            l5-7.3l4-3.3l4.7-2.7l5.3,3.7l6.7,1.3c0,0,7.3,1.3,9.3,1.3s6.3,0.7,6.3,0.7L92.7,207.3z" />
                                        <polygon id="Tooth2" fill="#FFFFFF" data-tooth="adult" data-key="2"
                                            points="79.7,288.3 71.7,291 55,293 40.3,291.3 36,287 33,273.7 36.3,260 42,248.7 44.7,244.7
                                        50.3,246.7 56,249 65.3,250.7 74,249.7 80.3,249.7 82.3,254 85.3,259.3 87,267.7 87.7,274.7 85.3,282.7 	" />
                                        <polygon id="Tooth1" fill="#FFFFFF" data-tooth="adult" data-key="1"
                                            points="33,314.3 38,325.7 45.7,335.7 55.7,341.7 64.7,343 73.3,340 77.7,335.7 81.3,326.3
                                        82,314.3 81.3,302 80.7,292.7 73.7,292 51.3,293.7 38.7,293.7 34,298 31.7,302.3 32,311 	" />
                                    </g>
                                    <g id="adult-outlines">
                                        <g id="XMLID_210_">
                                            <path id="XMLID_208_" fill="#010101"
                                                d="M372.6,180.5c0.2,1.4-2,2.3-2.9,1.2c-0.7-1.1,1.5-1.8,2.4-0.9L372.6,180.5z" />
                                            <path id="XMLID_207_" fill="#010101"
                                                d="M71.4,392.6c-0.5,1.1-2,1.5-2.9,0.9c-0.3-1.6,2.6-2.4,3.2-0.9L71.4,392.6z" />
                                            <path id="XMLID_199_" fill="#010101"
                                                d="M83.6,183.9c1.2,0.1,2.2,1.1,2.3,2.3c-1.2,1.3-3.7-1.1-2.4-2.3L83.6,183.9z" />
                                            <path id="XMLID_192_" fill="#010101"
                                                d="M341.6,587.6c-0.3-0.9,1.1-1.3,2-1.1c0.7,1.1-0.3,2.8-1.6,2.8
                                                                                                                                                                C341.2,589.2,341,588,341.6,587.6L341.6,587.6z" />
                                            <path id="XMLID_188_" fill="#010101"
                                                d="M87.8,552.3c-1.5,0-3,0-4.6,0c-0.4-0.6-0.5-1.3-0.4-2c1.4-0.4,2.8-0.5,4.2-0.3
                                                                                                                                                                c0.3,0.7,0.6,1.5,0.8,2.2L87.8,552.3z" />
                                            <path id="XMLID_186_" fill="#010101"
                                                d="M63.1,269.9c2.1,0.4,3.5,2.9,2.7,4.9c-1.8-0.7-3-2.8-2.7-4.7L63.1,269.9z" />
                                            <path id="XMLID_64_" fill="#010101"
                                                d="M407.7,456.5c5.4-9,6.6-22,0.9-30c-0.6-1.7-1.7-3.4-2.9-4.4c-0.9-0.7-1.8-1.4-2.6-2.1
                                                                                                                                                                c-0.4-0.4-0.8-0.7-1.2-1c2.4-1.1,4.5-3.1,5.6-5.4c2.5-5.1,1.8-11,0.8-16.6c-1.6-8.7-4.1-17.6-9.8-24.5c-5.6-6.9-15-11.3-23.5-8.9
                                                                                                                                                                c-9.2,2.6-14.9,12.4-15.5,21.9c-0.6,9.5,3,18.8,7.2,27.4c1,2.1,2.1,4.3,2.2,6.7c0,2.1-0.8,4.2-1.5,6.2c-3.5,9.5-4.8,19.7-4.1,29.8
                                                                                                                                                                c0.4,4.9,2.8,10.8,6.5,13.2c-0.6,0.6-1.2,1.5-1.8,2.1c-1.2,1.2-2.5,2.3-3.6,3.6c-5,4.6-6.7,12.7-7.1,19.9
                                                                                                                                                                c-0.5,8.9-0.8,18.9-7.3,24.9c-9.4,8.5-15.3,20.7-16.3,33.3c-0.4,4.8-0.9,10.9-5.5,12.3c-16.4,5.2-26.6,24.8-21.3,41.2
                                                                                                                                                                c-8.6-1-20.5,0.4-21.6,9c-0.4,3.3,1.1,6.5,0.9,9.8c-0.1,2.3-1.9,4.8-4,5.4c-1.4-1.1-2.7-2.2-4.5-2.8c-1.3-0.4-1.7-0.9-2.4-1.7
                                                                                                                                                                c0.1,0,0.2,0,0.3,0.1c-1.4-4.1-8-3.8-10.7-0.3c-2.7,3.4-2.7,8.2-2.9,12.5c-0.2,4.4-1,9.2-4.5,11.8c-2.2-4.9-4.5-10-8.7-13.3
                                                                                                                                                                S238,632,234,635.6c-5.2,4.7-2.9,13.6-6.3,19.8c-4.4-1.8-5.7-7.3-7-11.9c-1.3-4.6-4.6-9.9-9.4-9.1c-2.6,0.4-4.4,2.6-6.1,4.6
                                                                                                                                                                c-4.8,5.8-9.5,11.6-14.3,17.4c-4.6-9,3.5-22.7-4.5-29c-6.7-5.2-15.8,1.6-21.4,7.9c1-5.8,2.1-11.8,0.3-17.4
                                                                                                                                                                c-1.8-5.6-7.4-10.4-13.1-9.2c-5.6,1.2-8.2-6.7-8.1-12.4c0.1-4.8-0.7-11.1-4.4-13.2c-1.3-1.9-2.7-3.8-4-5.7c-1.7-2.5-3.2-4.2-6-5.6
                                                                                                                                                                c0,0-0.1,0-0.1,0c-3.4-2.8-7.7-4.4-12-4.4c3.2-16.9-5.5-35.3-20.6-43.5c4.2-10.4,2.9-22.8-3-32.3c-3.1-5.8-7.1-11.1-12.4-14.8
                                                                                                                                                                c3.8-12.1,5.3-24.8,4.6-37.5c-0.2-2.9-0.8-6.2-2.4-8.6c-0.4-1.2-1-2.3-1.9-3.1c-1.1-0.9-2.6-1.6-4.1-2.1c1.1-0.7,2.1-1.6,2.9-2.6
                                                                                                                                                                c3-3.6,4.3-8.2,5.4-12.7c2.4-9.5,4.5-19.9,0.6-28.9c-3.2-7.3-10.3-12.7-18.2-13.8s-16.2,2.2-21.3,8.3c-4.6,5.6-6.4,13.1-7.9,20.2
                                                                                                                                                                c-2.1,9.3-3.3,20.9,4.5,26.4c2,1.4,1.7,4.7,0.3,6.7s-3.6,3.5-5.1,5.5c-2.6,3.6-2.5,8.5-2,13c1.5,12.7,5.6,25.1,11.8,36.3
                                                                                                                                                                c-0.4,0.7-0.9,1.3-1.2,2c-0.8,1.5-1,3.2-1.1,4.8c-0.8,3.2-0.2,6.9,0.5,10.2c3,14.2,8.1,30.9,21.9,35.3c-5,5.4-2.4,14,0.5,20.8
                                                                                                                                                                c2.7,6.4,5.5,12.9,10.3,18c4.8,5,12.1,8.3,18.7,6.4c-4,19.4,13.3,40,33,40.1c-1.1,2.1-2.1,4.2-3.1,6.4c-0.2,0.4-0.1,0.8,0.1,1.1
                                                                                                                                                                c-2.2,6.2,0.8,14.6,7.4,16.3c7.7,2,18.2-2.8,22.3,3.9c5.4,9,15.4,15,25.9,15.7c-0.2-0.2-0.5-0.3-0.7-0.5c1,0.1,2,0.2,3,0.2
                                                                                                                                                                c1.5,0.1,2.8,0.2,4.1-0.6c6.6,5.3,15.8,7.3,24,5.3c2.2,0,4.3,0.2,6.5-0.2c2.3-0.4,4.4-1,6.3-2.3c8.3,3.6,18.2,3.2,26.2-1
                                                                                                                                                                c0.3-0.1,0.5-0.1,0.8-0.2c1.3-0.3,2.5-0.6,3.5-1.5c0.2-0.2,0.3-0.5,0.3-0.7c1.2-0.9,2.3-1.8,3.5-2.7c13.1,6.3,31.1-2.4,34.2-16.7
                                                                                                                                                                c7.4,3.6,17.1,1.8,22.7-4.2c5.6-6,6.8-15.8,2.7-22.9c19.4-1.8,35.2-21.6,32.6-40.9c21.2-5.9,36-29.1,32.3-50.8
                                                                                                                                                                c9.8-4.6,14.6-15.7,18.6-25.8c3.1-7.9,5.7-17.9-0.4-23.8C399.1,470.9,404,462.6,407.7,456.5z M40.6,410c-1-1.9-0.5-4.3,0-6.4
                                                                                                                                                                c1.1-4.4,2.2-8.8,3.3-13.2c1.5-5.8,3.3-12.1,8.1-15.6c1.4-1,2.9-1.7,4.5-2.2c7.1-2.5,15.4-1.7,21.5,2.7c6.1,4.4,9.5,12.5,7.6,19.7
                                                                                                                                                                c-1.5,6-0.9,12.3-2.8,18.2c-1.9,5.8-7.9,11.3-13.7,9.2c-7.2-2.5-16.2,4.1-22.4-0.4C43.1,419.3,42.8,414,40.6,410z M45.6,471.3
                                                                                                                                                                c-1.3-5-2.5-10.1-3.8-15.1c-1-3.8-1.9-7.7-1.8-11.6c0.3-6.5,3.9-12.8,9.5-16.3c5.5-3.5,12.8-4,18.8-1.5c2.1,0.9,4.5,0.8,6.7,0
                                                                                                                                                                c1.8,0.3,3.9,1,5.3,2c3.9,11.8,4.2,24.7,1,36.6c-0.6,2.2-1.4,4.6-3.2,6c-1.5,1.3-3.5,1.7-5.5,2.1c-6.8,1.5-13.7,3-20.5,4.5
                                                                                                                                                                C48.6,479,46.5,474.7,45.6,471.3z M63.2,530c-3.3-1.7-5.2-5.3-6.6-8.7c-4.3-9.8-7-20.3-8.1-31c0.1-1,0.2-2.1,0.7-3
                                                                                                                                                                c0.4-0.9,1.1-1.7,1.6-2.6c0.2-0.1,0.4-0.1,0.6-0.3c0.4-0.2,0.5-0.6,0.4-1c8-4.9,17.7-7.1,27-6.1c0,0,0,0,0,0
                                                                                                                                                                c7.9,4.7,12.8,13.2,16.4,21.4c0,0.1,0.1,0.2,0.2,0.2c0.9,3.1,1.4,6.2,1.3,9.4c-0.1,7.2-4.2,14.8-11.1,16.8
                                                                                                                                                                C78,527.3,70.2,533.6,63.2,530z M89.1,577.8c-6.7-1.7-10.3-8.7-13.2-15c-1.4-3-2.7-6.1-4.1-9.1c-1.7-3.8-3.4-7.8-2.7-11.9
                                                                                                                                                                c0.7-3.9,3.5-7.2,6.9-9.3c3.4-2.1,7.2-3.2,11-4.3c2.1-0.6,4.3-1.2,6.5-1.1c4,0.2,7.5,2.6,10.3,5.4c6.6,6.5,10.6,15.4,11.1,24.6
                                                                                                                                                                c0.1,2.6,0,5.2-1.1,7.5c-1.3,2.7-3.8,4.5-6.1,6.3C102.3,575.2,95.8,579.5,89.1,577.8z M120.8,616.5c-7.1-1.9-12.8-7.5-16.2-14
                                                                                                                                                                c-3-5.7-4.5-12.3-3-18.6c1.5-6.2,6.4-11.8,12.7-13c6.2-1.2,12.2,1.8,17.6,5.1c1.1,1.2,2.1,2.6,3.1,4.1c1.2,1.7,2.3,3.4,3.5,5
                                                                                                                                                                c3.6,8,6.2,17.3,1.6,24.6C136.4,615.9,127.9,618.4,120.8,616.5z M150.4,642.4c-5.6,2-12.3,1.4-16.7-2.6c-3-2.7-4.5-7-3.9-10.9
                                                                                                                                                                c0,0,0,0,0,0c1.3-2.7,2.6-5.4,4-8c3.6-4.3,7.6-8.8,13.1-9.8c7.7-1.5,15.6,5.5,16.1,13.3C163.7,632.3,157.9,639.8,150.4,642.4z
                                                                                                                                                                 M184.5,662.6c-1.6-0.1-3.2-0.3-4.8-0.4c-5.9-3.9-11.8-7.7-17.6-11.6c-1.4-0.9-3-2-3.4-3.7c-0.6-2.6,1.7-4.8,3.8-6.4
                                                                                                                                                                c3.9-2.9,7.8-5.9,11.7-8.8c2.2-1.7,4.7-3.4,7.5-3c4.8,0.7,6,7.1,6,12c0,7.1,0,14.1,0.1,21.2c0.3,0.3,0.6,0.6,0.9,0.9
                                                                                                                                                                C187.4,663,185.8,662.7,184.5,662.6z M212.9,667.5C212.9,667.5,212.8,667.5,212.9,667.5c-7.3-0.3-14.5-2.1-21-5.4
                                                                                                                                                                c4.7-8,10.1-15.6,16.1-22.7c0.9-1,2-2.2,3.3-2.1c1.3,0,2.4,1.2,3.2,2.3c5.6,7.7,9.2,16.8,10.3,26.3c0.1,0,0.1,0.1,0.2,0.1
                                                                                                                                                                C221.2,667.9,217.1,667.3,212.9,667.5z M257.1,662.6c-0.3-0.1-0.6,0-0.9,0.2c-1,0.9-2.6,1-3.8,1.3c-0.4,0.1-0.8,0.3-1.3,0.4
                                                                                                                                                                l-12.4,1c-3.6,0.3-8.3-0.1-9.4-3.5c-0.6-1.7,0.1-3.6,0.7-5.3c1.7-4.7,3.5-9.5,5.2-14.2c1.3-3.6,4-7.9,7.7-6.9
                                                                                                                                                                c1.4,0.4,2.5,1.5,3.4,2.6C252.6,645.1,259.2,654,257.1,662.6z M366.7,407.2c-2.7-7.6-5.5-15.8-3.5-23.6c0.6-2.6,1.8-5.1,2.1-7.7
                                                                                                                                                                c0.4-3.1,2.8-5.8,5.7-7.2c2.8-1.4,6.1-1.8,9.3-1.8c5.7,0,11.8,1.4,15.8,5.4c5.1,5.2,5.6,13.2,7.5,20.3c0.9,3.4,2.2,6.7,2.8,10.2
                                                                                                                                                                s0.2,7.3-1.9,10.1c-2.1,2.8-6.3,4.2-9.3,2.3c-7-4.4-17.3,4.1-24-0.7C368.8,412.8,367.7,409.9,366.7,407.2z M368.9,463.2
                                                                                                                                                                c-1.7-1.9-2-4.6-2.2-7.2c-0.8-9.6-1.5-19.8,2.9-28.3s15.9-14.2,24-9c1.8,1.2,4,1.4,6.1,0.9c1.4,1.1,2.5,2.3,3.9,3.3
                                                                                                                                                                c1.5,1.1,3.2,2.9,3.4,4.8c0.1,0.4,0.3,0.7,0.6,0.8c3.2,9.3-0.5,21.4-4.7,31.2c-1.8,4.2-6.5,9.1-9.8,6
                                                                                                                                                                C386.9,460.1,374.5,469.6,368.9,463.2z M285,655.6c-4.7,3.2-10.7,3.7-16.3,4.2c-1.5,0.1-3.2,0.2-4.5-0.7c-1.9-1.4-1.7-4.2-1.3-6.5
                                                                                                                                                                c1.3-8.2,2.6-16.5,3.8-24.7c1.6-1.4,3.7-2.3,5.8-2.5c1.3,0.9,1.7,2.6,3.2,3.3c0.9,0.5,2,0.5,2.9,1c0.5,0.3,1.1,0.7,1.6,1.1
                                                                                                                                                                c1.7,4.1,7.2,6,9.6,9.9C292.6,645.7,289.7,652.4,285,655.6z M311.4,641.3c-7.7,3.9-18.2,0.5-22.1-7.2c-0.7-1.4-0.8-3.1-0.8-4.6
                                                                                                                                                                c0-2.8-0.1-5.5-0.1-8.3c-0.1-3.2,0-6.6,1.9-9.1c2.2-2.7,6-3.5,9.5-3.4c7.5,0.2,15.3,3.8,18.8,10.5
                                                                                                                                                                C322.5,626.9,319,637.4,311.4,641.3z M349.8,590.1c-3.7,7.8-8.6,15.5-16.2,19.6c-7.6,4.1-18.5,3.1-23.2-4.2
                                                                                                                                                                c-3-4.6-3-10.6-1.5-15.8c2.3-8.3,7.9-15.7,15.4-20c2.7-1.6,5.7-2.8,8.8-2.6c3.9,0.2,7.4,2.6,10.6,4.8c3.6,2.6,7.6,5.7,8.1,10.1
                                                                                                                                                                C352.1,584.8,351,587.5,349.8,590.1z M382.6,543c-1.9,4.3-4.8,8.1-7.3,12.1c-3.4,5.4-6.2,11.7-11.8,14.7c-6.2,3.2-13.8,1.4-19.9-2
                                                                                                                                                                c-3.5-2-6.9-4.7-8-8.6c-1.1-3.9,0.5-8.1,2-11.9c1.8-4.4,3.6-8.8,5.4-13.3c2.8-7,6.6-14.8,13.9-16.7c6.1-1.5,12.2,1.8,17.6,5
                                                                                                                                                                c3.1,1.9,6.4,3.9,8.2,7C385.1,533.4,384.5,538.7,382.6,543z M397.9,508c-2.4,4.8-5.1,10-10,12.1c-5.6,2.4-12,0-17.6-2.4
                                                                                                                                                                c-8-3.4-11.8-13.2-11-21.9c0.7-7.7,4.2-14.8,7.9-21.7c0.5-0.5,1-0.9,1.5-1.4c0.5-0.5,1.1-1,1.5-1.5c0.2-0.2,1.1-1.6,1.3-1.6
                                                                                                                                                                c0.3,0.1,0.5,0,0.7-0.1c1,0.2,2.1,0.2,3.2-0.2c8.8-2.8,19.7-1.8,25.3,5.5C407.9,484.2,403,497.5,397.9,508z" />
                                            <path id="XMLID_183_" fill="#010101"
                                                d="M378.3,306.7c1.2,0.4,1.9,1.7,1.7,2.9c-1.9,0.2-3.7-1.6-3.6-3.4c0.5-0.6,1.6-0.3,1.8,0.4
                                                                                                                                                                L378.3,306.7z" />
                                            <path id="XMLID_177_" fill="#010101"
                                                d="M358.7,536.6c0.7,2.3,2.4,4.2,4.7,5.2c3.3-3,6.9-6.1,11.4-6.2c-1.9,3.5-5.3,6.2-9.1,7.1
                                                                                                                                                                c-3.2,0.8-4.9,4.6-4.4,7.9c0.5,3.3,2.6,6.1,4.6,8.7c-1.2,1.5-3.5-0.3-4.4-2c-0.9-1.7-2.9-3.7-4.3-2.4c-1.2-2.8,1.5-5.7,1.7-8.7
                                                                                                                                                                c0.3-4.4-4.6-8.2-3.5-12.4c0.5-0.8,1.8-0.5,2.4,0.2S358.5,535.7,358.7,536.6z" />
                                            <path id="XMLID_176_" fill="#010101"
                                                d="M63.1,270.1c-1.4-0.5-2.4-2.1-2.2-3.6c0.2-1.5,1.5-2.9,3-3.1c-0.2,2.2-0.5,4.4-0.9,6.7
                                                                                                                                                                L63.1,270.1z" />
                                            <path id="XMLID_175_" fill="#010101"
                                                d="M320.6,597.9c-0.2-1-0.3-1.9-0.5-2.9c1.7-0.7,3.5,0.6,5.3,0.9c3.5,0.6,6.7-2.8,7.3-6.3
                                                                                                                                                                s-0.8-7-2.1-10.3c0.6-0.1,1.2-0.2,1.7-0.3c5.3,5.5,4,15.7-2.4,19.8c-0.6,0.4-1.3,0.8-2.1,0.8C325.4,599.9,323,596.8,320.6,597.9z" />
                                            <path id="XMLID_174_" fill="#010101"
                                                d="M119.7,592.5c2.5-1.5,6.2-0.5,7.6,2.1C124.7,595.7,121.3,594.8,119.7,592.5z" />
                                            <path id="XMLID_172_" fill="#010101"
                                                d="M389.2,304.3c1.4-0.6,2.6,1.8,1.7,3c-1,1.3-2.7,1.4-4.3,1.5c-0.6-1.8,0.9-3.9,2.8-4
                                                                                                                                                                L389.2,304.3z" />
                                            <path id="XMLID_167_" fill="#010101"
                                                d="M97.4,545.2c-0.7,1.1-1.4,2.1-2.1,3.2c-0.8,0.8-2.3-0.3-2.3-1.4c0-1.1,0.9-2.1,1.7-2.9
                                                                                                                                                                c0.9-0.9,1.8-1.8,2.7-2.7C98.3,542.4,98.3,544.2,97.4,545.2L97.4,545.2z" />
                                            <path id="XMLID_165_" fill="#010101"
                                                d="M58.9,456c-0.1-1.2-0.3-2.3-0.4-3.5c0.7-0.1,1.5-0.2,2.2-0.3c-0.4,1.4,0.2,2.9,0.8,4.3
                                                                                                                                                                c0.6,1.4,1.2,2.9,0.7,4.3c-0.5,1.4-2.6,2.1-3.5,0.9C58.4,459.7,58.5,457.8,58.9,456L58.9,456z" />
                                            <path id="XMLID_163_" fill="#010101"
                                                d="M59,444.6c-0.2-1.4,1.6-2.4,2.9-1.8c1.2,0.6,1.6,2.4,1,3.6c-0.6,1.3-2,2-3.3,2.3
                                                                                                                                                                c-2,0.3-3.2-3.1-1.4-4.1L59,444.6z" />
                                            <path id="XMLID_162_" fill="#010101"
                                                d="M378.1,510.6c0.5-3.6,0-7.3-1.3-10.7c1.9,1.7,4.9,1.8,7,0.3c2-1.5,2.8-4.5,1.7-6.8
                                                                                                                                                                c2.9,1,5.9,1.8,8.9,2.3c-6,3.6-12.5,8-13.6,14.8C379.9,510.6,379,510.6,378.1,510.6z" />
                                            <path id="XMLID_161_" fill="#010101"
                                                d="M66.5,229c0.7,1.9,1.4,3.8,2.1,5.7c-0.7,0.2-1.4,0.3-2.1,0.5c-1-2.7-2.1-5.4-3.1-8.1
                                                                                                                                                                C64.3,226,65.9,227.6,66.5,229z" />
                                            <path id="XMLID_157_" fill="#010101"
                                                d="M373.1,216.3c1.2-2.9,3.1-5.5,5.5-7.5c0.8,0,1.6,0,2.4,0
                                                                                                                                                                C379.5,212.4,377,216.7,373.1,216.3z" />
                                            <path id="XMLID_154_" fill="#010101"
                                                d="M63.1,219.6c-0.2,2.4-1.4,4.6-3.4,6c-1.2-0.9-0.8-2.8-0.3-4.2c1-2.8,2-5.6,3.1-8.3
                                                                                                                                                                C64.3,214.7,64.6,217.8,63.1,219.6L63.1,219.6z" />
                                            <path id="XMLID_150_" fill="#010101"
                                                d="M91.9,552.9c2.1,0.3,4.5,0.9,5.6,2.7c1.1,1.8-0.7,5-2.7,4c-1.9-2.4-3.9-4.8-5.8-7.2
                                                                                                                                                                C90,552.6,91,552.8,91.9,552.9z" />
                                            <path id="XMLID_148_" fill="#010101"
                                                d="M111.7,137.3c-3.4,0.7-6.9,0.6-10.2-0.3c-1.3-1.3-1.6-3.5-0.6-5c1.3,2,3.7,3.3,6,3.2
                                                                                                                                                                c1,0,2.1-0.3,3.1-0.1C111.1,135.3,112,136.3,111.7,137.3L111.7,137.3z" />
                                            <path id="XMLID_129_" fill="#010101"
                                                d="M102.5,140.9c-0.4,1.9-1,3.7-1.8,5.4c-2.4,0.3-4.7,0.6-7.1,0.9c2.5-2.7,4.9-5.4,7.4-8
                                                                                                                                                                c0.2-0.5,1.1-0.5,1.4,0C102.7,139.6,102.6,140.3,102.5,140.9z" />
                                            <path id="XMLID_119_" fill="#010101"
                                                d="M262.1,54.8c-4.1-0.8-8.2-2.1-12.1-3.7c-0.5-0.2-0.9-0.8-1-1.4
                                                                                                                                                                C253.8,47.6,259.9,50,262.1,54.8z" />
                                            <path id="XMLID_117_" fill="#010101"
                                                d="M359.4,184.9c2.1-2.4,4.2-4.8,6.3-7.2c0.1,4.3-2.2,8.6-5.9,10.8c-0.8,0.3-1.6-0.6-1.6-1.4
                                                                                                                                                                C358.3,186.2,358.9,185.5,359.4,184.9z" />
                                            <path id="XMLID_97_" fill="#010101"
                                                d="M77.7,167c1.7,0.3,3,1.6,4.3,2.8c2,1.9,4,3.8,6,5.8c-3.1,0.1-5.4,2.7-7.5,4.9
                                                                                                                                                                c-2.1,2.2-5,4.4-8,3.6c-0.1-0.7-0.2-1.5-0.3-2.2c3.3-0.2,6.5-2.5,7.6-5.6C81,173.1,80.1,169.3,77.7,167z" />
                                            <path id="XMLID_67_" fill="#010101"
                                                d="M201.2,50.3c-6.4,2.4-13.2,3.8-20.1,4.1C186.6,49.8,194.4,48.2,201.2,50.3z" />
                                            <path id="XMLID_60_" fill="#010101"
                                                d="M391.5,280.2c-1.3-2.9-4.6-4.4-7.2-6.3c-2.6-1.9-5-5.3-3.6-8.2c0.5-1,1.4-1.8,2-2.7
                                                                                                                                                                c1.1-1.5,1.7-3.3,1.6-5.1c1.3,1.2,1.6,3.3,1.3,5.1c-0.3,1.8-1,3.5-1.1,5.3c-0.2,1.8,0.3,3.9,1.9,4.8c1.5,1,4.1,0,4.1-1.8
                                                                                                                                                                C391.7,274.1,392.1,277.3,391.5,280.2z" />
                                            <path id="XMLID_49_" fill="#010101"
                                                d="M70.8,209.5c1.2,2.9,2.5,5.9,3.7,8.8c0.3,0.7,0.6,1.4,0.5,2.1c-0.1,0.7-0.5,1.3-0.8,1.8
                                                                                                                                                                c-1.2,1.8-2.4,3.6-3.6,5.4c-1.4-0.3-1.7-2.2-1.2-3.5c0.5-1.3,1.6-2.4,2-3.7c0.9-3.6-3.4-7.1-2.2-10.6
                                                                                                                                                                C69.6,209.3,70.4,209.2,70.8,209.5z" />
                                            <path id="XMLID_48_" fill="#010101"
                                                d="M292.7,71.3c-0.8-0.7-1.6-2.1-0.7-2.6c4.8,1.5,9,4.8,11.6,9.1c-0.4,0.6-1.1,1-1.8,1.1
                                                                                                                                                                C298.8,76.3,295.7,73.8,292.7,71.3z" />
                                            <path id="XMLID_46_" fill="#010101"
                                                d="M382.4,441.6c-0.7-0.5-1.3-1.3-1.4-2.1c3.8-1.8,5.5-6.9,3.7-10.6c1.3-0.9,2.4,1.3,3.6,2.3
                                                                                                                                                                c1.7,1.6,4.4,0.7,6.3-0.4c2-1.2,4.1-2.6,6.3-2.1c-0.8,3-3.7,5.3-6.8,5.4c-2.8,0.1-5.1,3.1-4.5,5.8
                                                                                                                                                                C387.5,438,383.5,438.9,382.4,441.6z" />
                                            <path id="XMLID_44_" fill="#010101"
                                                d="M366.5,164.1c-0.4,1.3-0.7,2.6-1.4,3.8c-2.4,4.5-8.6,6.6-13.2,4.3
                                                                                                                                                                c2.9-3.2,9.5-1.5,11.4-5.4c0.4-0.8,0.5-1.7,1-2.4S366,163.5,366.5,164.1z" />
                                            <path id="XMLID_43_" fill="#010101"
                                                d="M392.5,251.6c-1.6,3-0.8,7.1,1.9,9.3c1.4,1.2,1.9,3.3,1.2,5c-0.8,1.7-2.8,2.7-4.6,2.3
                                                                                                                                                                c1.3-2.6,1.3-5.9,0.1-8.6c-0.8-1.8-2.2-3.4-2.3-5.3C388.7,252.4,391,250.3,392.5,251.6z" />
                                            <path id="XMLID_39_" fill="#010101"
                                                d="M370.9,231.8c1.5-4.6,5.7-8.2,10.5-8.9c1.6-0.2,4,0.9,3.2,2.4
                                                                                                                                                                C380.1,227.5,375.5,229.6,370.9,231.8z" />
                                            <path id="XMLID_35_" fill="#010101"
                                                d="M385,401c0.2-3.3-2-6.6-5.1-7.7c-0.9-0.3-2-0.5-2.8-1.1c-0.8-0.6-1.3-1.8-0.6-2.6
                                                                                                                                                                c4.7-0.4,9.5,2.4,11.5,6.7c0.6,1.2,0.9,2.7,0.3,3.9C387.7,401.5,385.9,402,385,401z" />
                                            <path id="XMLID_66_" fill="#010101"
                                                d="M408.9,285.8c7.9-15.8,6-38.2-9.1-47.3c7.5-16.1,2.5-37.1-11.5-48.1
                                                                                                                                                                c-2.6-15.9-11.2-30.8-23.7-41.1c-3.5-2.9-3.3-8.2-3.9-12.7c-0.3-2.2-1.3-4.7-2.7-6.4c0,0,0-0.1-0.1-0.1c-0.7-1.1-1.7-2-2.6-2.8
                                                                                                                                                                c-1.4-2-3.1-4-5-5.3c-0.4-0.3-0.8-0.5-1.3-0.8c0.1,0,0.3,0,0.4,0c-0.4-0.2-0.8-0.3-1.2-0.5c-0.8-0.4-1.7-0.8-2.4-1.4
                                                                                                                                                                c-1.1-0.7-1.9-1.1-2.9-1.1c-1.4-0.8-2.7-1.8-3.8-3c-2.7-3-3.9-7.8-1.4-11c4-5.3,0.2-13.6-5.8-16.5s-13.1-2.1-19.7-1.2
                                                                                                                                                                c3.3-3.9,3.4-9.8,1.4-14.5c-2.1-4.7-6-8.3-10.2-11.2c-8.1-5.6-17.6-9.1-27.4-10c-2.4-1.7-4.3-3.7-6.5-5.4c-2.5-1.9-5.6-3-8.4-4.3
                                                                                                                                                                c-0.1,0-0.1,0-0.2,0c-12.1-6.2-27.1-6.6-39.4-0.7c-4.2,2-9-0.1-13.5-1.3c-14.4-4-31,2.2-39.3,14.6c-15.1-3.5-32.1,5.4-37.9,19.8
                                                                                                                                                                c-1.4,3.4-3.4,7.8-7,7.1c-6.8-1.2-13.3,4.4-15.5,11c-2.2,6.6-1,13.7,0.4,20.5c0.6,2.8-3.4,4-6.2,4.4c-13.6,2-24.2,16.2-22.3,29.8
                                                                                                                                                                c0.4,2.5,0.9,5.6-1,7.2c-8,6.9-16.4,14.4-19.6,24.5c-1.8,5.7-1.1,12.4,1.7,17.5c0,0-0.1,0-0.1,0.1c-1,0.7-2.1,1.4-3.1,2
                                                                                                                                                                c-0.4,0.2-0.7,0.5-1.1,0.7c-6.1,0.9-10.5,7.4-11.6,13.7c-1.2,6.9,0.3,14.1-0.4,21.1c-1,10.4-6.6,19.8-9.9,29.7
                                                                                                                                                                c-3.3,9.9-3.8,22.3,3.8,29.5c-3.6,2.2-6.3,5.9-7.2,10c-0.2,0.2-0.2,0.4-0.3,0.6c-0.2,0.2-0.3,0.4-0.3,0.7c0,2.3,0,4.6,0.8,6.8
                                                                                                                                                                c0.3,6.8,3.2,13.5,7.8,18.5c0.2,0.5,0.4,0.9,0.7,1.3c0,0,0,0,0,0c1.5,2.6,3.5,4.6,6.1,6.4c2,1.4,4,3.3,6.1,4.7
                                                                                                                                                                c4.3,4.6,12.1,5.7,18,3c7-3.2,11.5-10.5,13.2-18.1s1-15.4,0.3-23.1c-0.4-4.3-0.7-8.5-1.1-12.8c1.8-2.6,3.1-5.5,4-8.5
                                                                                                                                                                c0.3-0.7,0.6-1.3,0.8-2c0.4-1.5,0.6-3.2,1-4.7c0.2-0.7,0.3-1.3,0.3-2c3.4-9.7-9.3-22.2-2.6-30.3c8.7-10.4,12.1-25,9-38.2l2-1.8
                                                                                                                                                                c0.9-0.3,1.7-0.8,2.4-1.6c1-1.2,2.3-2,3.3-3.3c0.6-0.8,1.1-1.6,1.5-2.4c0.5-0.5,1-1,1.5-1.6c0-0.1,0.1-0.1,0.1-0.2
                                                                                                                                                                c3.6-3.1,4.9-9.4,4.8-14.6c-0.2-7-0.1-15.7,6.2-18.7c11.4-5.6,16.9-21,11.4-32.5c6.1-0.7,12.5-2.7,16.2-7.6
                                                                                                                                                                c6.6-8.8,1.2-21.2-4.3-30.7c9.3,2.2,16.2,12.8,25.7,11.6c6.5-0.8,11.1-7.3,11.9-13.7s-1.1-13-3.1-19.2c8.3,4.9,11.6,17,21,19.4
                                                                                                                                                                c6.8,1.8,13.9-2.8,17.4-8.9c3.5-6.1,4.2-13.3,4.9-20.3c5.4,3.6,7,10.6,9,16.7c2,6.1,6,12.9,12.4,13.3c4.8,0.4,9-3,12.5-6.3
                                                                                                                                                                c5.5-5.4,10.6-11.3,14.9-17.7c3,5.6,1.5,12.3,1,18.6c-0.4,6.3,1.2,13.9,7.2,16.1c7.7,2.7,14.8-6,23-6.9c-3,7.9-7.4,16.3-4.6,24.2
                                                                                                                                                                c2.5,7.1,10.3,11.1,17.8,11.1c-0.7,0.9-1.3,1.9-1.5,3c-0.4,1.8-0.1,3.8-0.1,5.6c0,0.1,0,0.3,0.1,0.4c-1,9.7,7,19.7,16,25
                                                                                                                                                                c3.6,2.1,8,5.4,6.6,9.2c-2.5,6.8-1,14.8,3.5,20.4c0.3,2.7,2.6,5.2,4.3,7.2c1.5,1.8,3.2,3.4,5.2,4.5c0.5,1,1,2.1,1.5,3.1
                                                                                                                                                                c-1.2,1.6-1.1,4.2-0.9,6c0.1,1.3,0.3,2.7,0.7,3.9c0.4,1.1,1.1,2,1.5,3.2c1.5,6.7,4,13.2,7.3,19.1c1.3,2.3,2.8,4.8,2.3,7.5
                                                                                                                                                                c-2.5,14-1.1,28.8,4.1,42c1.6,4.1-0.5,8.6-2.4,12.6c-2.8,5.6-5.4,11.5-6.1,17.7c-0.7,6.2,0.7,13,5.2,17.4
                                                                                                                                                                c5.3,5.3,13.3,6.2,20.7,6.7c3.7,0.2,7.4,0.4,10.9-0.7c8-2.5,12.5-10.9,16.1-18.5c4.2-8.8,8.1-20,1.9-27.5
                                                                                                                                                                C405.4,293.1,407.3,289,408.9,285.8z M73.7,338.6c-5.9,4.3-13.9,3.3-21,1c-1.7-1.2-3.4-2.8-5-3.9c-3-2.1-5.4-4.3-6.9-7.7
                                                                                                                                                                c-0.1-0.2-0.2-0.3-0.3-0.3c-0.3-0.7-0.5-1.5-0.8-2.2c-2.2-5.4-4.3-10.8-6.5-16.2c-0.1-0.2-0.2-0.3-0.3-0.5c-0.4-1.6-0.4-3.3-0.3-5
                                                                                                                                                                c0.2-0.2,0.2-0.5,0.2-0.7c2.2-2.7,4.5-5.4,6.7-8.1c11.8-0.5,23.7-1,35.5-1.6c1.5-0.1,3.2-0.1,4.3,0.8c1.5,1.2,1.7,3.4,1.7,5.3
                                                                                                                                                                c0,5.1,0.1,10.3,0.1,15.4C81.2,323.6,80.6,333.5,73.7,338.6z M84.1,260.4c0.5,4.1,0.4,8.7,2.4,12.1c0.2,2.1-0.8,4.8-1.3,6.7
                                                                                                                                                                c-0.4,1.7-1.8,4.2-3,5.3c-0.1,0.1-0.1,0.1-0.1,0.2c-5.9,4.8-15.2,6.3-23.2,7c-8.3,0.7-18.8,0.2-22.4-7.3
                                                                                                                                                                c-1.8-3.6-1.3-7.9-0.8-11.9c1.2-9.5,2.9-19.9,10.3-26c8.5,5.4,19.2,7.1,29,4.6C79.7,249.7,83.5,255.5,84.1,260.4z M93,214.7
                                                                                                                                                                c-0.7,12.3-5.3,25.3-15.8,31.7c-10.5,6.4-27.2,2.5-30.3-9.4c-3.3-12.5,0.2-26.5,8.9-36.1c0.9-0.3,1.6-0.8,2.4-1.3
                                                                                                                                                                c1.2-0.7,2.4-1.5,3.6-2.3c0.1,0,0.1-0.1,0.1-0.1c2.2,3.2,5.3,5.6,9.2,6.4c7.5,1.6,18-1.8,21.3,5.2C93.2,210.6,93.1,212.7,93,214.7
                                                                                                                                                                z M102,194.9c-0.4,0.1-0.6,0.5-0.7,0.9c0,0,0,0,0,0.1c-0.7,0.7-1.3,1.4-2,2.1c-0.9,0.9-1.9,1.9-3,2.6c-0.5,0.3-1,0.4-1.5,0.6
                                                                                                                                                                c-4.2-0.2-8.4-0.4-12.5-0.7c-6.7-0.3-14.3-1.1-18.5-6.4c-6.7-8.4,0-20.5,6.6-29c3.2-4,7.5-8.5,12.5-7.4
                                                                                                                                                                c10.3,2.3,22.3,6.3,24.9,16.5C109.7,181.4,105.9,188.6,102,194.9z M123.9,148.8c-3.2,5.8-8,11.5-14.5,12.7
                                                                                                                                                                c-4.4,0.8-8.9-0.6-13.1-2c-3-1-6.1-2-8.5-4c-5.1-4.1-6.5-11.6-4.7-17.8c1.8-6.3,6.4-11.4,11.5-15.5c1.3-1.1,2.7-2.1,4.2-2.8
                                                                                                                                                                c5.1-2.4,11.8-1,15.5,3.2c2.1,2.4,5.7,2.8,8.3,4.5c3.3,2.2,5,6.4,4.9,10.4C127.4,141.5,125.8,145.3,123.9,148.8z M143,105
                                                                                                                                                                c0.8,3,1.6,6,1.4,9.1s-1.6,6.2-4.1,7.9c-2.5,1.7-5.6,1.8-8.6,1.8c-4,0.1-8.1,0.1-11.6-1.5c-4-1.8-6.9-5.6-8.4-9.8
                                                                                                                                                                c-1.5-4.1-1.7-8.6-1.6-13c0.2-4.3,0.8-9,3.8-12.2c4.7-5.2,13.5-4.5,19-0.1C138.3,91.4,141,98.3,143,105z M169.3,97.2
                                                                                                                                                                c-3.9,2.5-9.2,1.3-13.1-1.1s-7.3-5.7-11.5-7.8c-4.5-2.2-10.4-3.4-12.3-8c-2.2-5.1,2.2-10.6,6.5-14.1c2.3-1.9,4.8-3.6,7.3-5.2
                                                                                                                                                                c4.6-2.9,9.8-5.5,15.3-5.2s11,4.3,11.4,9.8c0.1,1.8-0.3,3.5-0.5,5.2c-0.4,4.6,1,9.2,1.4,13.9C174.3,89.4,173.2,94.7,169.3,97.2z
                                                                                                                                                                 M215.9,55.6c-0.9,3.8-1.7,7.6-2.6,11.4c-0.9,4-1.8,8.1-4,11.6c-2.2,3.5-5.8,6.4-9.9,6.4c-5.8,0.1-10.2-4.9-13.8-9.5
                                                                                                                                                                c-4.6-5.9-9.2-12-11.4-19.2c-0.6-2-1-4.2-0.1-6.1c1-2.1,3.4-3.2,5.6-4c6.5-2.4,13.2-4.1,20-5c3.1-0.4,6.3-0.7,9.4,0.1
                                                                                                                                                                c3,0.8,5.9,2.8,7,5.7C217.1,49.8,216.5,52.8,215.9,55.6z M253.2,78.2c-2.8,3.4-6.1,7.1-10.5,7.4c-7.2,0.6-11.7-7.5-14.3-14.3
                                                                                                                                                                c-1.9-5-3.9-10.1-5.8-15.1c-1.4-3.6-2.7-7.7-0.9-11c2-3.9,7.2-4.9,11.6-5.1c9.6-0.4,19.3,0.9,28.5,3.6c2.6,1.2,5.4,2.4,7.4,4.3
                                                                                                                                                                c1,1,2,1.8,3,2.6C266.5,60.3,260.2,69.5,253.2,78.2z M285.7,94.2c-4.4,1.9-10.3,3.5-13.3-0.2c-1.7-2-1.8-5-1.7-7.6l0.4-23.8
                                                                                                                                                                c0.1-5.1,5.8-8.5,10.8-8.2c5,0.4,9.5,3.4,13.6,6.3c2.6,1.9,5.3,3.7,7.9,5.6c4.3,3,9,7.2,8.1,12.3c-0.8,4.4-5.5,6.9-9.7,8.6
                                                                                                                                                                C296.5,89.6,291.1,91.9,285.7,94.2z M305.4,123.7c-2.5-0.8-4.9-2.2-6.6-4.2c-4-4.9-3-12.1-0.9-18c1.7-4.8,4.3-9.8,9-11.6
                                                                                                                                                                c3.4-1.3,7.1-0.7,10.7-0.6c4,0.2,8-0.2,11.8,1.1c3.8,1.2,7.2,4.7,6.8,8.6c-0.8,7.5-4,14.8-9.7,19.8
                                                                                                                                                                C320.7,123.7,312.5,126,305.4,123.7z M322.8,157.1c-6-5.6-10.1-13.2-11.6-21.2c0-1.1,0-2.1,0-3.2c0.1-1.8,0.7-2.9,1.8-4.2
                                                                                                                                                                c0.2-0.2,0.2-0.4,0.2-0.6c8-0.9,15.2-5.7,21.2-11.1c1.9,1.1,3.9,2.1,6,2.8c3.1,1.8,6.6,3.6,9.3,5.9c0.7,0.6,1.2,1.4,1.9,2
                                                                                                                                                                c0.2,0.2,0.4,0.3,0.6,0.5c0,0,0,0,0,0c0.7,0.5,1.4,1,2,1.5c0.4,0.6,0.8,1.2,1.1,1.8c0.2,0.3,0.5,0.5,0.8,0.5
                                                                                                                                                                c3,4.4,3.6,10.5,1.6,15.5c-2.6,6.8-8.9,11.6-15.7,14.1c-3,1.1-6.1,1.7-9.3,1.3C329,162.1,325.6,159.8,322.8,157.1z M341.6,198.1
                                                                                                                                                                c-1-1.1-2.5-2.8-3.5-4.5l-0.8-2.2c0-0.1,0-0.1,0-0.2c0-0.3-0.1-0.5-0.3-0.7l-1.3-3.8c-1.6-4.7-3.3-9.8-1.5-14.5
                                                                                                                                                                c3.7-9.8,18.7-9.8,24.5-18.5c2.3-3.4,7.5-0.5,10.1,2.7c5.9,7.2,10.8,15.2,14.5,23.7c0.9,2,1.7,4.1,1.4,6.3c-0.5,4.3-5,6.8-9,8.6
                                                                                                                                                                c-10.1,4.6-21.5,9.2-31.8,5.3C343.1,199.7,342.3,198.9,341.6,198.1z M347.3,212.8c-0.2-1.5-0.2-3.3,0.2-4.5
                                                                                                                                                                c11.8-4.2,23.7-8.3,35.5-12.5c1.7-0.6,3.4-1.2,5.2-0.9c2.3,0.3,4.2,2.1,5.6,4c4.5,6.2,5.3,14.2,5.9,21.8
                                                                                                                                                                c0.4,5.3,0.7,11.2-2.7,15.2c-2.3,2.8-5.9,4.1-9.4,5.1c-5.9,1.7-12,2.8-18.2,3.3c-3.1,0.2-6.5,0.2-8.8-1.9
                                                                                                                                                                c-1.3-1.2-2.1-2.9-2.8-4.6C354.3,229.6,350.8,221.2,347.3,212.8z M360.8,269.5c-0.6-3.5-2-6.9-2.5-10.4s0.2-7.6,3-9.8
                                                                                                                                                                c1.9-1.4,4.3-1.8,6.6-2c8.9-0.7,18.5,0.3,25.9-4.8c3-2,7.2-0.5,9.8,2.1c7.1,6.8,6.6,18.1,5.7,27.9c-0.7,7.5-2.3,16.3-9.1,19.5
                                                                                                                                                                c-2.9,1.4-6.1,1.4-9.3,1.4c-3.8,0-7.6,0.1-11.4,0.1c-5.3,0-11.3-0.2-15-4.1C359.9,284.3,361.9,276.3,360.8,269.5z M402.2,323.4
                                                                                                                                                                c-2.2,4.8-4.6,9.9-9,12.8c-5.7,3.8-13.2,3-20,1.9c-4-0.7-8.1-1.4-11.6-3.6s-6.2-5.9-5.8-10c0.6-7.6,2.2-15.1,4.8-22.3
                                                                                                                                                                c0.9-2.4,2.1-5,4.5-6c1.7-0.7,3.6-0.3,5.4,0c9.6,1.7,19.4,1.4,28.9-0.6c1.3-0.3,2.7-0.6,4-0.3c2.4,0.7,3.6,3.4,4,5.9
                                                                                                                                                                C408.6,308.9,405.3,316.4,402.2,323.4z" />
                                            <path id="XMLID_33_" fill="#010101"
                                                d="M79.4,509.8c0.8,0.4,0.3,1.7-0.6,1.9c-0.8,0.2-1.7-0.2-2.6-0.3c-3.9-0.5-6.7,4.6-10.6,4.6
                                                                                                                                                                c0-1.1,0.7-2,1.3-2.8c2-2.6,4-5.1,6-7.7C73.4,508.4,76.5,510.5,79.4,509.8z" />
                                            <path id="XMLID_32_" fill="#010101"
                                                d="M64.9,501.7c0.4-2.9,0.9-5.8,1.3-8.7c0.2-1.2,0.5-2.6,1.7-3c2.3,3.5,6.6,5.5,10.8,5
                                                                                                                                                                c-1.9,2.6-6,1.8-9,0.7C69.5,498.5,67.5,501.1,64.9,501.7z" />
                                            <path id="XMLID_30_" fill="#010101"
                                                d="M380.9,376.7c0.2-0.9,1.6-0.7,2.1,0.1s0.2,1.7,0.2,2.6c-0.3,4.6,4.5,8.7,9,7.8
                                                                                                                                                                c-0.7,1.9-2.6,3.2-4.6,3.2C383.2,387.4,380.5,382,380.9,376.7z" />
                                            <path id="XMLID_25_" fill="#010101"
                                                d="M339.6,130.4c2.1,3.2,3.6,6.8,4.7,10.5c-4.2-1.5-9.2,2.8-8.3,7.2c-2-0.7-2.5-3.5-1.7-5.5
                                                                                                                                                                c0.8-2,2.3-3.6,3.3-5.5c1-1.9,1.3-4.5-0.2-5.9C338.1,130.9,338.8,130.7,339.6,130.4z" />
                                            <path id="XMLID_21_" fill="#010101"
                                                d="M381.7,454.8c-1.1-0.5-0.7-2.4,0.4-3.1c1.1-0.7,2.4-0.7,3.5-1.3c3-1.5,3.3-5.5,3.2-8.8
                                                                                                                                                                c1.3-0.3,2.3,1.4,2.2,2.8c0,1.4-0.5,2.9,0.2,4c0.8,1.4,2.7,1.5,4.2,2c1.5,0.5,3.1,2.2,2.1,3.5
                                                                                                                                                                C392.5,451.9,386.5,452.2,381.7,454.8z" />
                                            <path id="XMLID_20_" fill="#010101"
                                                d="M386.8,329.1c0.4-5-2.7-10.1-7.4-12.1c0.1-1.4,2.3-1,3.6-0.6c2.7,0.9,5.8,0.1,7.7-2
                                                                                                                                                                c1.2,0.2,1.1,2.1,0.3,3c-0.8,0.9-2.1,1.4-2.7,2.5c-0.9,1.7,0.4,3.6,1,5.4S388.4,330,386.8,329.1z" />
                                            <path id="XMLID_19_" fill="#010101"
                                                d="M113.4,601.5c-0.9-0.8-0.7-2.2-0.4-3.3c0.4-2,0.8-4,1.2-5.9c0.9-4.5,3.8-8.6,7.7-10.9
                                                                                                                                                                c1,1.4,0.4,3.4-0.7,4.8s-2.5,2.5-3.3,4c-1,1.9-1,4.1-1.3,6.2C116.3,598.5,115.4,600.8,113.4,601.5z" />
                                            <path id="XMLID_18_" fill="#010101"
                                                d="M388.3,481.6c-0.7,3-1.5,6.2-3.5,8.5c-2.1,2.3-5.9,3.4-8.4,1.5c5.6-2.1,9.5-8.1,9.2-14.1
                                                                                                                                                                c0.7-0.8,2.2-0.3,2.7,0.7C388.8,479.3,388.6,480.5,388.3,481.6z" />
                                            <path id="XMLID_15_" fill="#010101"
                                                d="M155,66.8c1.3-0.8,3.7-1,3.7,0.5c-5.6,3.5-11.1,7-16.8,10.4c-1.6-1,0.1-3.4,1.7-4.3
                                                                                                                                                                C147.4,71.2,151.2,69,155,66.8z" />
                                            <path id="XMLID_13_" fill="#010101"
                                                d="M56,411.5c-1.4-1.5,0.9-3.6,2.6-4.9c3.5-2.6,5.3-7.3,4.4-11.6c0.9-1,2.8-0.5,3.4,0.7
                                                                                                                                                                c0.6,1.2,0.4,2.7-0.1,4C64.7,404.8,60.8,409,56,411.5z" />
                                            <path id="XMLID_7_" fill="#010101"
                                                d="M55,311.6c-1.1,2.8-3.7,4.9-6.7,5.5c2.3-2.7,3.9-6.1,4.5-9.7c2.3,0.8,4.7,1.6,7,2.4
                                                                                                                                                                c0.9,0.3,2.1,1.3,1.4,2c-1.2,1.4-0.2,3.6,0.4,5.3c0.7,1.8,0.4,4.5-1.5,4.6C59.7,317.9,57.8,314.3,55,311.6z" />
                                            <path id="XMLID_6_" fill="#010101"
                                                d="M47.9,271.6c1.3-4.4,3-8.8,4.9-13c1.6,0.1,2.4,2.2,2,3.7c-0.4,1.6-1.5,2.9-2,4.4
                                                                                                                                                                c-0.6,1.5-0.3,3.6,1.1,4.2c2.7,1.1,4.3,4.2,3.8,7.1c-1,1-2.2-0.9-2.6-2.2C54.3,272.8,50.8,270.2,47.9,271.6z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="tooths">Child Tooths</label>
                            <div class="hidden-tooth-inputs" data-tooth=""></div>
                            @error('tooths')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                           <div class="tooth-chart" data-id="sections[${section}][attributes][${attribute}][inputs][${input}][childTooths]">
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 450 700" enable-background="new 0 0 450 700" xml:space="preserve">
<g class="Spots">
	<polygon id="ToothT" fill="#FFFFFF" data-tooth="child" data-key="T" points="65.7,373.5 74,375.2 82,380.8 86.3,384.8 90.3,390.2 92.7,395.8 93,404.8 93,416.8
		93,424.5 94.3,432.2 95.7,438.5 94.7,444.2 92.3,450.2 89,453.5 77.7,456.5 68.7,460.5 64.3,461.2 54.7,456.5 48.3,450.2 42,442.2
		36.3,425.2 33.3,407.8 34.3,399.5 36,392.8 39.7,383.5 47,377.2 57,373.2 	"/>
	<polygon id="ToothS" fill="#FFFFFF" data-tooth="child" data-key="S" points="93.7,456.2 82.7,455.8 70.7,460.8 66.3,467.2 63.7,474.2 62,487.2 63.3,500.2
		66.3,509.5 70.3,517.2 76.3,524.8 85.3,531.2 93.3,534.8 102.3,535.8 109.3,534.5 119,529.8 121.7,521.2 122,510.2 120.7,502.8
		114.3,484.5 108.7,470.8 103,462.5 	"/>
	<polygon id="ToothR" fill="#FFFFFF" data-tooth="child" data-key="R" points="129.3,532.2 137,535.2 142.7,541.2 146,548.8 147.7,557.8 144.7,565.2 136.7,570.5
		123,573.8 113,574.2 105,572.8 101.3,564.8 103,551.2 107.3,541.2 111.3,535.5 124,531.5 	"/>
	<polygon id="ToothQ" fill="#FFFFFF" data-tooth="child" data-key="Q" points="164.3,564.5 168.3,568.8 173,592.2 172,598.2 169.3,601.8 162,601.8 152,599.8
		142.3,595.5 131,586.8 130.7,584.5 135,575.8 140.3,570.2 149.7,564.5 159,562.8 	"/>
	<polygon id="ToothP" fill="#FFFFFF" data-tooth="child" data-key="P" points="208,576.5 218,607.2 214,611.5 206.7,613.2 191,612.8 179,606.8 172.3,601.5
		174,597.8 190.3,578.2 199.7,571.8 205.7,573.8 	"/>
	<polygon id="ToothO" fill="#FFFFFF" data-tooth="child" data-key="O" points="244.3,574.2 235.7,575.2 230.7,581.8 225.7,593.5 221.7,604.5 220.3,609.8 224,613.5
		234.3,615.5 248.7,613.8 258.7,610.8 264,606.2 265.3,598.8 	"/>
	<polygon id="ToothN" fill="#FFFFFF" data-tooth="child" data-key="N" points="306.3,575.8 298.7,569.2 289.7,566.2 280.7,564.2 275.3,566.8 272,572.2 268.7,583.8
		267.3,593.2 266.3,599.2 266.7,603.8 270.7,607.8 276.3,608.8 286.7,605.2 300,597.5 307.7,590.5 309,583.5 	"/>
	<polygon id="ToothM" fill="#FFFFFF" data-tooth="child" data-key="M" points="335,532.2 341.7,546.5 343.3,562.8 339.7,570.5 331.7,573.5 309,572.5 302,569.2
		298,564.5 299.7,548.2 303,539.5 307.3,531.8 315.3,525.2 321.3,525.2 325,525.5 	"/>
	<polygon id="ToothL" fill="#FFFFFF" data-tooth="child" data-key="L" points="354,450.2 365.7,453.8 377,459.5 384.3,469.2 385,481.5 382.7,491.8 369.7,517.8
		357.3,527.8 340.7,532.2 331.7,528.5 324.3,523.5 321,515.2 320.7,504.2 325.3,489.5 330.3,470.2 335,460.5 343.7,453.2 	"/>
	<polygon id="ToothK" fill="#FFFFFF" data-tooth="child" data-key="K" points="391.7,370.2 379,367.8 366.7,370.2 356.3,378.8 350.3,388.2 347.7,396.2 348,411.5
		346.7,427.8 347.7,438.5 352,445.2 364.7,453.2 374.3,455.5 381.7,454.8 389.7,451.8 394.3,445.8 397.7,433.8 401.7,421.5
		406.7,413.5 409.7,400.5 408.7,390.5 404.3,380.2 	"/>
	<polygon id="ToothJ" fill="#FFFFFF" data-tooth="child" data-key="J" points="384.3,231.2 391.3,232.5 402.3,241.5 409,253.8 414.3,267.2 416,281.8 413.7,300.2
		409.3,308.8 400.3,314.5 386,317.2 375,314.8 367.3,310.5 358.7,303.5 353.7,291.5 353.7,277.8 354.7,267.8 350.3,259.8
		351.7,248.2 357.7,239.5 367.7,237.5 	"/>
	<polygon id="ToothI" fill="#FFFFFF" data-tooth="child" data-key="I" points="359.3,167.2 367.3,169.8 375.3,182.5 384,199.8 389.7,211.8 389.3,220.5 386,227.5
		377.3,233.5 363.3,238.5 355.3,237.5 348.3,233.2 343.3,224.8 337,211.5 330.7,195.8 328,186.8 332.7,175.2 342.7,168.5 	"/>
	<polygon id="ToothH" fill="#FFFFFF" data-tooth="child" data-key="H" points="305.7,136.5 303,143.8 301,150.5 304,161.5 313,170.2 323,172.8 331.7,172.5
		339.3,168.8 346,162.5 350.3,152.2 351.3,141.2 347.3,134.5 343,132.2 334,131.5 322.3,130.2 316,129.8 	"/>
	<polygon id="ToothG" fill="#FFFFFF" data-tooth="child" data-key="G" points="277.3,98.8 276.7,107.2 276,119.2 276,129.5 279.7,138.2 285.7,141.2 293.3,141.5
		301.7,135.8 316.7,126.8 320,122.5 320,116.2 316.3,109.8 301.7,101.8 294.7,98.8 282,97.5 	"/>
	<polygon id="ToothF" fill="#FFFFFF" data-tooth="child" data-key="F" points="222,87.5 222.7,93.8 226.7,98.2 231,107.8 236.7,121.5 242,125.8 248,126.8 257,120.2
		275.3,101.5 276,95.2 273.7,92.2 266,85.8 248.7,80.5 236.3,80.2 229,81.8 	"/>
	<polygon id="ToothE" fill="#FFFFFF" data-tooth="child" data-key="E" points="168.3,94.5 172,103.5 175.3,107.5 184,120.5 190.3,127.5 198.7,128.5 203.3,124.8
		209.7,115.2 219.7,92.5 218.7,85.8 209,83.8 191.3,82.5 182,84.2 173.7,88.2 	"/>
	<polygon id="ToothD" fill="#FFFFFF" data-tooth="child" data-key="D" points="123.7,124.2 131.3,131.2 143.3,137.5 151.3,141.8 159,142.5 165.7,137.5 169.3,125.8
		169,108.8 169.7,100.2 165,95.5 158.3,95.2 145.7,97.8 138.7,102.5 130,108.2 124.3,114.2 	"/>
	<polygon id="ToothC" fill="#FFFFFF" data-tooth="child" data-key="C" points="106.7,132.2 118,132.2 130.3,132.5 139.7,138.2 144.7,147.8 144.7,160.8 134.3,173.8
		121.7,180.2 115,180.2 107.7,174.5 100,169.8 98.7,156.8 97.3,147.8 98.3,138.8 104.7,133.2 	"/>
	<polygon id="ToothB" fill="#FFFFFF" data-tooth="child" data-key="B" points="90.2,242.2 97.3,236.1 106.3,224.2 114.9,200.1 117.3,189.4 113,179.1 95.7,169.8
		86.2,169.8 71.9,179.1 63.5,191.3 58.6,202.5 54,215.2 55.8,227.2 65.8,238.9 79.1,242.2 	"/>
	<polygon id="ToothA" fill="#FFFFFF" data-tooth="child" data-key="A" points="55.2,236.1 60,237.2 69.8,240.2 86.9,243.3 92,247 95.7,255.8 95.7,271.2 94.7,286.5
		90.2,305.2 82.8,312.8 72,318.5 56.7,319.3 48.8,317.5 40.8,311.5 33,300.3 31.3,284.7 34.2,273.8 39.3,256.3 42.3,248 	"/>
</g>
<g id="child-outlines">
	<g id="XMLID_9_">
		<path id="XMLID_167_" fill="#010101" d="M67.9,257.2c0.1-0.5-0.5-1-0.9-0.8l0-0.1c-0.4,0.6-0.4,1.4,0,2
			C67.4,258,67.8,257.7,67.9,257.2z"/>
		<path id="XMLID_145_" fill="#010101" d="M391.2,293.4c0.2,0.6,1.1,1.1,1.6,0.6c1.1-0.9,0.1-3.1-1.3-2.9l0,0.4
			C391.3,292.1,391,292.8,391.2,293.4z"/>
		<path id="XMLID_144_" fill="#010101" d="M90.4,191.3c-0.6,0.7,0.3,1.9,1.3,2l0.2-0.2c0.9,0.9,2.7-0.8,1.8-1.8
			C92.6,191.3,91.5,191.3,90.4,191.3z"/>
		<path id="XMLID_143_" fill="#010101" d="M63.6,393.6c1,0.1,2-0.9,1.9-1.9c-0.1-1-1.3-1.8-2.3-1.4l0.1,0.5
			C63.4,391.7,63.5,392.6,63.6,393.6z"/>
		<path id="XMLID_142_" fill="#010101" d="M380.9,401c-1,1.3-1,3.2,0,4.5c1.8,2.5,0.9,6-0.5,8.8c-1.4,2.7-3.4,5.4-3.5,8.5
			c0,1.1,0.1,2.2-0.2,3.2c-0.7,2-3.3,2.7-5.4,2.6c-2.1-0.1-4.4-0.5-6.4,0.4c0.7,2,3.6,1.8,5.8,1.5c4.1-0.5,8.4,0.7,11.7,3.1
			c-3.5-6.9-2.7-15.8,2.1-21.9c1.3-1.6,1.2-4,0.3-5.9C383.9,403.9,382.4,402.4,380.9,401z"/>
		<path id="XMLID_141_" fill="#010101" d="M94.8,506.7c0.2,1,1.5,1.6,2.4,1c-0.3-0.8-0.5-1.7-0.8-2.5l0.2-0.4
			C95.6,504.7,94.6,505.7,94.8,506.7z"/>
		<path id="XMLID_140_" fill="#010101" d="M352.5,484c1-0.4,1.9-1.3,2.3-2.3c-0.6-0.7-1.8-0.7-2.5,0c-0.6,0.7-0.6,1.9,0.1,2.5
			L352.5,484z"/>
		<path id="XMLID_139_" fill="#010101" d="M75.9,434.2c-1-0.6-1.9-1.3-2.9-1.9c-2.2-1.5-4.4-2.9-6.6-4.4c-0.7-0.5-0.5-1.6-0.2-2.5
			c1.2-3.9,0.6-8.3-1.6-11.7c-0.6-1-2.2-1.8-2.7-0.7c4.3,5.2,3.7,13.8-1.2,18.5c-1,0.9-2,2.8-0.8,3.3c2.6-3,7.3-3.8,10.7-1.9
			C72.4,433.8,74.4,435.4,75.9,434.2z"/>
		<path id="XMLID_138_" fill="#010101" d="M155.2,105.8c-0.6-1.3-2.3-2-3.6-1.5l0,0.1c-1,0.3-1.7,1.4-1.4,2.4
			C151.9,107,153.7,106.7,155.2,105.8z"/>
		<path id="XMLID_137_" fill="#010101" d="M82.5,186.8c0.6,1.3,1.5,2.4,2.7,3.2l0,0.1c0.6-0.1,1.1-0.3,1.7-0.4
			C86.3,188,84.4,186.7,82.5,186.8z"/>
		<path id="XMLID_136_" fill="#010101" d="M361.4,216.8l0.5-0.8c2.1-0.5,2-4.2-0.1-4.6C360.5,212.9,360.4,215.2,361.4,216.8z"/>
		<path id="XMLID_135_" fill="#010101" d="M355.9,500.4c1.7-2.7,3.5-5.7,6.5-6.7c1.4-0.4,3.3-0.8,3.3-2.2c0-1.6-2.5-1.7-3.9-1
			c-4.1,2-6.9,5.9-9.5,9.7c-1.3,1.8-2.6,3.6-3.8,5.5C351.6,505.8,354.2,503.1,355.9,500.4z"/>
		<path id="XMLID_134_" fill="#010101" d="M386.1,264.8c-0.5,1.9,0.5,4.2,2.3,5.1c0.7,0.1,1.3-0.9,0.8-1.4l0.1,0
			C388.2,267.3,387.2,266,386.1,264.8z"/>
		<path id="XMLID_133_" fill="#010101" d="M63.5,402.1c1,1,2.6,1.2,3.8,0.6c-0.8-2-2.1-4.4-4.2-4.6l0.1,0.2
			C62.4,399.4,62.6,401.1,63.5,402.1z"/>
		<path id="XMLID_116_" fill="#010101" d="M417.3,277.6c0-1.2-0.2-2.7-0.6-3.8c0.3-2.8-0.4-5.4-1.4-8c-0.3-2.5-1.1-4.9-2.4-7
			c-0.3-1-0.7-2-1.2-2.9c0-0.1,0-0.1,0-0.2c0-1.1-0.5-2.2-0.9-3.2c-1.9-4.4-3.9-8.9-7.1-12.6c-2.6-3-6-5.2-9.3-7.4
			c-0.6-0.4-1.3-0.8-2-1c-1.8-1.3-4.3-1.9-6.7-2c4.1-4.4,6.7-10.2,6.1-16.2c-0.5-4.5-2.6-8.6-4.8-12.6c-3.2-6-6.5-12-9.7-18.1
			c-3.1-5.7-6.3-11.6-11.6-15.2c-4.5-3-10.9-3.8-15.3-1.1c-2.1,0.4-4.3,0.6-6.5,0.7c5-6,8.2-13.4,9-21.2c0.3-3.7-0.3-8.1-2.4-11
			c0,0,0,0,0,0c-0.2-0.4-0.4-0.6-0.7-0.9c-0.3-0.3-0.7-0.6-1-0.9c-0.6-0.7-1.1-1.2-2-1.6c-2.4-1.1-5.4-1-8-0.8
			c-0.2,0-0.3,0.1-0.5,0.1c-6.5-1.4-13.2-2.3-19.9-2.6c3.8-2.9,4.7-8.5,3-13c-1.7-4.5-5.4-7.9-9.4-10.6c-9.6-6.5-21.5-9.8-33.1-9
			c-12.2-16.7-37.4-22.3-55.4-12.2c-2.3,1.3-5.2,0.7-7.8,0c-15.6-3.7-34-4.8-45.5,6.4c-1.9,1.9-4.1,4.3-6.8,4
			c-10.6-1.1-20.7,4.2-29.6,10.1c-4.8,3.2-9.7,6.9-11.7,12.2c-2,5.4,0.3,12.7,5.9,14c-7.3,3.3-16.2-2.3-23.6,0.8
			c-6.7,2.8-8.8,11.3-8.3,18.5c0.2,3.3,0.9,6.6,1.8,9.8c0.5,3.3,0.9,6.5,1.3,9.8c-5.2-1.3-10.7-1.2-15.8,0.6
			C68,175,60.5,191.7,54.8,206.8c-1.1,2.8-2.2,5.7-2.4,8.8c-0.5,6.9,3.4,13.3,7.2,19.1c-7.9,1.9-14.9,7.2-19.2,14.1c0,0,0,0-0.1,0.1
			c-0.5,0.8-0.9,1.6-1.2,2.4c-3.5,4.8-3.7,12.4-4.2,17.9c0,0.2,0,0.3,0.1,0.5c-8.1,13.7-6.4,33,5.3,43.9
			c13.3,12.3,37.4,10.5,47.8-4.3c5.8-8.1,7.2-18.5,8.5-28.3c1.3-10.4,2.6-21.4-1.6-31c-1.3-2.9-2.9-6.7-0.5-8.8
			c10.6-9.8,18-23,20.8-37.2c0.2-0.1,0.3-0.3,0.4-0.6c1.5-4.8,1.9-9.2,1.7-13.9c0.3-2.4,0-4.8-0.9-7c10,0.5,20.1-4.5,25.6-12.8
			c5.6-8.3,6.4-19.5,2.1-28.6c7.7,5.9,20.5,2.9,24.8-5.8c4.4-8.8,0.5-20.3,4.3-29.1c1.8,2.6,3.4,5.3,5,8.1c0,0.1,0.1,0.1,0.1,0.2
			c1.7,4,3.7,7.8,6.8,10.8c4.5,4.4,11.8,6.5,17.1,3.2c3.2-2,5.1-5.5,6.8-8.9c4.1-8.3,7.9-16.8,11.4-25.4c5,3.1,7.5,8.9,9.4,14.5
			c1.9,5.6,3.6,11.5,7.7,15.7c4.1,4.2,11.6,5.7,15.7,1.5c5.2-5.3,10.4-10.6,15.5-15.9c2.1-2.2,4.3-4.4,6.7-6.2c0.1,2,0,4-0.3,6
			c-0.2,1.5,0.1,2.8,0.1,4.2c-1,4.7-1.1,9.6-0.3,14.4c1,6.2,4.3,12.8,10.3,14.6c6.2,1.9,12.6-2.1,17.9-5.8
			c-2.7,7.5-4.1,15.9-1.7,23.5c2.5,7.6,9.8,14,17.8,13.3c4.4-0.4,10.9-1.4,11.4,2.9c0.1,1.3-0.5,2.6-1,3.8
			c-4.9,11.6,1.5,24.4,8.6,35.2c0,0.1,0,0.2,0,0.3c0.3,2.1,0.8,4.1,1.5,6c0,0-0.1,0.1-0.1,0.1c1.2,5.3,4.7,10.1,9.4,13
			c3,1.8,7.1,5,4.9,7.7c-5.4,6.9-5.8,17.2-1.2,24.6c0.3,1.4,0.4,2.8,0.3,4.2c-0.6,1.6-0.7,3.4-0.4,5.1c-0.1,0.1-0.2,0.3-0.2,0.4
			c-0.2,0.2-0.3,0.5-0.2,0.8c0.4,2.6,0.5,5.3,0.5,7.9c0,0.1,0,0.2,0,0.2c-0.8,4.8,0.2,9.9,2.6,14.2c3,5.4,7.8,9.6,13.1,12.7
			c6.7,3.9,14.4,6.1,22,5.6c7.7-0.5,15.3-4,20-10C417.2,300.2,417.4,288.5,417.3,277.6z M94.6,268.4c-0.7,5.7-1.3,11.4-2,17.2
			c-0.6,5-1.2,10-3,14.6c-5,12.8-19.9,20.9-33.4,18.2c-13.5-2.8-24-16.1-23.5-29.8c0.2-6.9,2.8-13.4,4.8-20c0.1-0.1,0.1-0.2,0.1-0.4
			c0.1-0.4,0.3-0.9,0.4-1.3c0.1-0.1,0.2-0.3,0.2-0.5c0-0.1,0-0.2,0-0.3c0-0.1,0-0.2,0.1-0.3c0.7-0.3,0.7-1.3,0.1-1.7
			c0.2-1.7,0.4-3.5,0.7-5.2c0.2-0.5,0.3-1.1,0.5-1.5c1-3.1,2.8-6.5,4.8-9.2c1.5-1.5,2.8-3.8,4.2-5.4c3.2-3.7,8.8-4.3,13.6-3.4
			s9.3,3,14.2,3.8c4,0.7,8.3,0.5,11.9,2.4C95.6,249.7,95.6,260.1,94.6,268.4z M113.3,202.6c-2,5.1-4,10.1-6,15.2
			c-2.1,5.3-4.3,10.6-8,14.9c-5.8,6.6-15.3,9.7-23.8,7.8c-8.6-1.9-15.9-8.6-18.4-17c-3.8-12.8,3-26.2,10.9-36.9
			c2.8-3.8,5.8-7.6,9.7-10.3c6.9-4.8,16.4-5.7,24.1-2.3c6,2.7,10.7,7.9,13.1,14C115.1,192.9,114.9,197.6,113.3,202.6z M143,160.1
			c-2.2,6.5-7.1,11.8-12.9,15.5c-3.9,2.5-8.6,4.3-13.1,3.2c-3.6-1-6.4-3.7-9.5-5.8c-1.8-1.2-3.8-2.2-5.8-2.9
			c-0.7-5.7-1.5-11.4-2.4-17.1c0.1-3.7,0.4-7.3,0.8-10.9c0.2-2.1,0.6-4.5,2.1-6c1.5-1.5,3.7-1.8,5.8-2c11.3-1.4,24.6-2,31.9,6.6
			C144.3,145.9,145.1,153.6,143,160.1z M168.6,106.4c-0.1,3.5-0.3,7-0.4,10.5c-0.2,5.8-0.4,11.7-2.5,17.1c-1.4,3.7-4.4,7.4-8.4,7.4
			c-1.1,0-2.1-0.3-3.2-0.7c-3-1-5.9-2.2-8.7-3.5c-5.1-2.4-10-5.2-14.6-8.4c-2.1-1.5-4.3-3.1-5.5-5.4c-1.2-2.3-1.4-5.4,0.3-7.3
			c6.6-7.5,15-13.4,24.2-17.2c4.1-1.7,8.6-3,13-2.1c1.5,0.3,2.9,0.8,3.9,1.9C168.7,100.6,168.7,103.7,168.6,106.4z M217.1,93.2
			c-3,7.1-6,14.1-9,21.2c-2.6,6.1-7,13.4-13.6,12.7c-7.5-0.8-9.7-10.8-15.2-15.9c-1.5-2.4-3-4.8-4.5-7.2c-0.2-0.4-0.6-0.5-0.9-0.6
			c-3.6-2.5-3.5-8.7-0.6-12.1c3.2-3.7,8.2-5,13-5.8c8.1-1.3,16.4-1.5,24.6-0.6c3,0.3,6.6,1.4,7.1,4.3
			C218.2,90.5,217.7,91.9,217.1,93.2z M269.6,105.4c-5.2,5.1-10.5,10.2-15.7,15.3c-2.3,2.2-4.9,4.6-8.1,4.5
			c-4.4-0.1-7.2-4.6-9.1-8.5c-2-4-4-8.1-5.5-12.3c-0.9-2.7-1.6-5.5-3.2-7.9c-1.5-2.2-3.7-4.2-3.8-6.8c-0.1-2.1,1.3-4.1,3-5.3
			c1.8-1.2,3.9-1.6,6-2c11.7-1.8,23.9,0.2,34.4,5.8c3.4,1.8,6.9,4.5,7.1,8.3C274.8,100.1,272.1,103,269.6,105.4z M296.2,137.6
			c-2.7,1.6-5.6,3.2-8.7,2.9c-6.1-0.5-9.4-7.7-9.6-13.8c-0.1-3.9,0.4-7.9,0.2-11.8c0.1-0.1,0.1-0.3,0.1-0.4c0.1-2-0.3-3.8,0-5.9
			c0.3-2.1,0.3-4.1,0.2-6.2c0-0.2-0.1-0.4-0.3-0.5c1.4-0.9,2.9-1.6,4.5-2.1c11-3.5,22.1,4.2,31.1,11.4c2.6,2.1,5.4,4.6,5.4,7.9
			c0,3.7-3.4,6.3-6.5,8.3C307.1,131,301.7,134.4,296.2,137.6z M319.4,170.8c-9.9-2.4-17.6-12.5-16.5-22.6
			c1.1-10.1,11.4-18.5,21.5-16.8c4.4,0.7,9.4,2.9,13.4,2.4c0.2,0.1,0.4,0.2,0.7,0.1c1.9-0.1,4.2-0.3,6.1,0.3
			c1.1,0.4,1.3,0.9,2.1,1.6c0.3,0.2,0.9,0.5,1,0.8c0.2,0.3,0.4,0.5,0.6,0.7c2.4,7.4,1.5,15.8-2.6,22.3
			C340.3,168.2,329.3,173.2,319.4,170.8z M345.4,226.6c-0.5-1.4-0.9-2.9-1.9-4c-0.1-0.1-0.3-0.3-0.4-0.4c0-0.1,0-0.1,0-0.2
			c-0.7-1.9-1-4-1.7-5.9c-0.2-0.5-0.4-1.1-0.7-1.6c0-0.1,0-0.1,0-0.2c0.1-0.5-0.2-0.8-0.5-0.9c-0.2-0.3-0.4-0.7-0.6-1
			c-0.4-1.3-0.9-2.6-1.5-3.8c-3.1-7-6.3-14.1-9.4-21.1c2.9-3.2,4.7-7.4,5-11.7c3-1.7,5.7-3.9,8.1-6.4c4.5,0,8.6-0.8,13-1.7
			c0,0,0.1,0,0.1,0c4.9,0.3,9.8,2.5,13.1,6.2c2.2,2.4,3.7,5.3,5.2,8.2c3.5,6.6,7,13.2,10.5,19.8c3.3,6.2,6.7,13.5,3.8,20
			c-1.2,2.7-3.4,4.9-5.7,6.8c-5.5,4.6-12.2,8.2-19.3,8.4C355.5,237.2,348,233.3,345.4,226.6z M414.2,283.8
			c-0.2,5.7-0.3,11.6-2.6,16.9c-3.5,8-11.8,13.5-20.5,14.6c-8.7,1.1-17.6-1.9-24.6-7.2c-6.3-4.7-11.3-11.8-11.5-19.7
			c0-1.1,0-2.4-0.2-3.5c0.1-0.1,0.2-0.3,0.3-0.5c0.5-2.2,0.7-4.3,0.7-6.5c0.7-3.8,1.6-7.9-0.2-11.2c-0.1-0.2-0.2-0.3-0.3-0.3
			c-0.1-0.4-0.3-0.8-0.5-1.1c-3.9-7.6-2.5-17.5,3.4-23.7c8-1.3,16.1-3.1,22.8-7.6c0.6-0.4,1.1-0.8,1.7-1.2c0.3,0.2,0.6,0.2,1,0
			c1.1-0.7,2.9,0,4.1,0.3c0.8,0.2,1.6,0.3,2.3,0.5c0,0,0,0,0,0.1c5.7,2.5,10.2,7.1,13.6,12.3c1.8,2.7,3.3,5.6,4.7,8.6
			c-0.3,0.4-0.2,1,0.4,1.3c0.1,0,0.2,0.1,0.3,0.2c1,2.2,1.9,4.4,2.8,6.6l1.6,3.9c0,0,0,0,0,0.1c0,3.1,0.4,6.2,1.1,9.3
			c0,0.2,0.1,0.3,0.2,0.4C414.3,278.7,414.3,281.3,414.2,283.8z"/>
		<path id="XMLID_80_" fill="#010101" d="M401.6,375c-9.8-10-27.2-12.3-38.5-3.9c-3.9,2.9-6.9,6.7-9.9,10.5c-2,2.6-4.1,5.2-5.2,8.4
			c-1,2.8-1.1,5.8-1.2,8.7c-0.3,7.7-0.7,15.4-1,23.1c-0.3,7.5-0.5,15.4,3,22.1c1.1,2.1-0.1,4.7-2,6.1c-1.8,1.4-4.1,2.1-6.2,3.2
			c-8.3,4.3-11.4,14.3-13.7,23.3c-1.9,7.5-3.9,15-5.8,22.5c-1.7,6.5-3.3,13.5-1,19.8c0.7,1.9-1.7,3.4-3.6,4.2
			c-0.6,0.3-1.1,0.7-1.6,1.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.3,0.1-0.4,0.2c-0.3,0.2-0.7,0.4-1.1,0.7c-1.4,1-2.8,1.9-4.1,3
			c-0.5,0.4-0.8,0.9-1.2,1.4c-0.2,0-0.5,0.1-0.7,0.3c-0.6,0.7-1.1,1.4-1.7,2c-0.5,0.4-0.9,0.8-1.2,1.4c-0.6,0.4-0.9,1.1-1.3,1.7
			c-1.9,3.6-3.5,7.4-4.7,11.4c-0.6,1.8-0.9,3.9-0.7,5.8c-0.1,0.1-0.1,0.3-0.1,0.5c0,1.4-0.1,2.8-0.1,4.3c-0.2,0-0.4,0-0.5,0
			c-0.4,1.2-0.6,2.8,0.5,3.3c0,0.3,0,0.5,0,0.8c0,1.1-0.1,2.2,0.1,3.2c-1.6,1-4,1.1-5.9,0.6c-3-0.9-5.7-2.8-8.8-3
			c-5.7-0.4-10.2,5-12.4,10.3c-2.2,5.2-3.2,10.8-3.2,16.4c0,0,0,0,0,0.1c0,2.7-0.6,5.3-1,7.9c-1.2-2.2-2.7-4.3-4.3-6.1
			c-3.5-4.2-7-8.4-10.6-12.6c-1.6-1.9-3.3-3.9-5.5-4.9c-3.8-1.8-8.6-0.4-11.8,2.4c-3.2,2.8-5.2,6.7-6.9,10.5
			c-2.9,6.5-5.4,13.2-7.4,20c-2.4-8.1-4.8-16.2-7.2-24.3c-1-3.4-2.2-7.1-5-9.3c-5.4-4.1-13.4-0.7-17.9,4.3
			c-4.5,5-7.5,11.6-12.9,15.5c-2-7.2-3.9-14.4-5.9-21.7c-0.6-2.1-1.2-4.3-2.5-6c-4-5.4-12.4-4.8-18.4-1.6c0.3-7.5-0.8-15.3-4.7-21.8
			c-3.9-6.4-11.1-11.2-18.6-11c-2.7,0.1-3.7-3.6-3.1-6.2c0.4-2.1,1.2-4.5,0.6-6.4c0-0.1,0-0.1,0-0.2c-0.1-0.5-0.2-1-0.2-1.5
			c0-0.5,0-1,0.1-1.4l0.1,0.2c0-0.2,0-0.4-0.1-0.6c0-1,0-2,0-3.1c0-0.2,0-0.3-0.1-0.4c0-1-0.1-2.1-0.2-3.1c0-0.7-0.1-1.4-0.4-2.1
			c-0.2-0.7-0.4-1.4-0.7-2.1c-3.5-18.7-12.6-36.4-25.9-49.9c-2.8-2.8,0.5-7.2,1.6-11c1.4-5.1-1.5-10.2-2.5-15.4
			c-1.1-6.1,0.6-12.3,0.8-18.5c0.5-13.3-6.5-26.8-18.1-33.1s-27.5-4.5-36.7,5.1c-10.1,10.6-10.5,27-7.9,41.4c1.5,8.7,4,17.5,9,24.8
			c4.7,7,11.6,12.4,19.4,15.4c2.4,0.9,2.1,4.3,1.4,6.7c-4.1,15.8-4,33.3,3.8,47.6c7.8,14.3,24.3,24.4,40.4,21.6
			c-5.5,5.7-6.7,14.2-7.7,22.1c-0.5,4-0.9,8.3,1.2,11.7c3.1,5,10,5.7,15.9,5.2c5.9-0.5,12.3-1.6,17.2,1.5c-4.1,0.5-6,6-4.3,9.9
			c1.7,3.8,5.5,6.2,9.2,8.1c4,2.1,8.1,4,12.3,5.7c6.6,2.7,14.5,4.8,20.7,1.1c0.1-0.1,0.3-0.2,0.4-0.3c0.6,1.2,1.4,2.3,2.2,3.4
			c1,1.3,2.3,2,3.7,2.6c3.4,3.7,8.4,6.1,13.4,6.9c7.4,1.2,14.9-0.5,22.2-2.2c2-0.5,4.2-1,6.1-0.3c2.1,0.7,3.6,2.7,5.5,3.9
			c3.1,2,7,1.9,10.7,1.4c7.7-0.9,15.3-2.9,22.4-5.9c3.3-1.4,6.7-3.3,8.3-6.5c0.8,0.1,1.4,1.2,1.9,1.8c0.4,0.5,0.9,0.8,1.4,1.1
			c1.9,1.2,4.3,1.8,6.5,1.6c3.5-0.3,6.8-1.9,9.9-3.5c3.1-1.6,6.3-3.2,9.4-4.8c3.3-1.7,6.7-3.4,9.4-6c5.6-5.4,7.2-14.4,3.8-21.4
			c7.2-0.2,14.5-0.4,21.7-0.6c2.9-0.1,5.9-0.2,8.5-1.6c6.5-3.5,6.7-12.6,5.2-19.8c-1.3-6.2-3.1-12.2-5.6-18
			c9.7,1.2,19.4-3.6,26.3-10.6c6.9-6.9,11.5-15.8,15.7-24.6c3-6.2,6-12.7,6.3-19.7c0.2-3.9-0.7-8-2.6-11.4c0-0.2,0-0.4-0.2-0.6
			c-1.9-2.6-3.9-5.2-5.8-7.8c1.1-3.3,6-4.3,9.5-5.9c9.1-4.4,9.5-16.8,13.2-26.2c1.8-4.8,4.7-9,6.7-13.7
			C413.6,401.4,411.4,385.1,401.6,375z M57.4,456.4c-7.9-4.7-13.5-12.6-16.9-21.2c-3.4-8.6-4.7-17.8-5.5-27
			c-0.3-3.2-0.4-6.7,1.3-9.3c1.4-2.2,1.5-5,2.1-7.6c2-8.9,10.4-15.5,19.3-16.8c9-1.3,18.2,2.3,25.1,8.2c2.8,2.4,5.2,5.2,6.8,8.5
			c4.9,10.1,0.7,22.1,2,33.2c0.6,5.5,2.6,10.9,2.5,16.5s-3.6,11.7-9.1,12.3c-4.5,0.5-9,2-12.8,4.5C67.9,460.5,62,459,57.4,456.4z
			 M76.8,523.7c-8.4-8.9-12.5-21.2-13.6-33.3c-0.4-5-0.4-10.2,1-15c2.2-7.8,8.2-14.5,15.9-17.1s16.8-0.7,22.5,5.1
			c4.1,4.2,6.2,9.8,8.1,15.3c3.5,9.7,7,19.4,10.5,29.1c0,1.3-0.2,2.6-0.1,3.9c0,1.3,0.1,2.5,0.3,3.8c0,0.4,0,0.8,0,1.1
			c0,0.3,0.1,0.4,0.2,0.6c-1.4,2.1-1.2,5.4-1.9,8c-1.2,4.2-5.3,7-9.5,8.4C98.6,537.3,85.3,532.6,76.8,523.7z M128.5,571.9
			c-3.9,0.2-7.7,1.1-11.6,1.3c-3.9,0.2-8-0.2-11.2-2.5c-1.1-0.8-2-1.8-2.5-3c-0.5-1.2-0.5-2.6-0.4-4c0.1-2.6,0.4-5.2,0.8-7.8
			c0.7-4.5,1.7-9,3.9-13c2.1-4,5.5-7.5,9.8-9c3.7-1.3,7.8-1,11.7-0.2c2.1,0.4,4.3,0.9,6.2,1.9c5.3,2.7,8.2,8.5,10.1,14.2
			c1.4,4.2,2.3,9.1-0.2,12.7c-0.9,1.4-2.3,2.4-3.6,3.4C137.6,568.7,133.4,571.7,128.5,571.9z M169.3,600.1c-2.6,2-6.3,1.4-9.4,0.3
			c-3.1-1.1-6.2-2.7-9.4-2.5c-1.1,0-2.1-0.6-3.1-1.2c-4.1-2.6-8.2-5.2-12.3-7.8c-1.1-0.7-2.2-1.5-2.6-2.7c-0.2-0.8,0-1.7,0.2-2.5
			c1.9-6.4,6.5-11.8,12.3-15.1c3.4-2,7.3-3.2,11.1-4.4c3.6-1.2,7.7,1,9.9,4.1c2.2,3.1,3,7,3.8,10.8c0.6,2.9,1.2,5.8,1.8,8.6
			C172.3,592,172.8,597.5,169.3,600.1z M213.6,609.9c-1.2,1-2.7,1.4-4.3,1.7c-12.1,2-25.1-1.3-34.7-9.1c0.1,0.2,0.2,0.4,0.2,0.6
			c-0.4-0.6-0.7-1.2-1-1.9c1.7-1.5,3.1-3.3,4.5-5.1c3.9-5.1,7.9-10.3,11.8-15.4c3.3-4.3,8.3-9.1,13.3-6.9c3.2,1.4,4.5,5.1,5.5,8.5
			l5.4,17.8C215.4,603.4,216.2,607.6,213.6,609.9z M263.3,604.2c-0.8,4.3-5.6,6.5-9.8,7.5c-8.2,2-16.8,2.5-25.2,1.6
			c-2.2-0.3-4.8-0.8-5.8-2.8c-0.9-1.8-0.3-3.9,0.4-5.8c2.6-7,5.5-13.9,8.8-20.6c2-4.2,5.2-8.9,9.9-8.6c3.1,0.2,5.5,2.7,7.6,5.1
			c4.6,5.2,9.1,10.6,12.5,16.6C262.7,599.3,263.8,601.7,263.3,604.2z M307.3,584.9c-0.6,6.3-6.5,10.4-11.9,13.8
			c-7.6,4.7-16.4,9.5-24.9,8.1c-0.5-0.4-0.9-1-1.3-1.4c-0.5-0.6-1.1-1.1-1.9-1.3c0.1-0.5,0.2-1,0.2-1.5c0.1-0.2,0.2-0.5,0.2-0.7
			c-0.7-4.5,1-8.8,1.1-13.3c0-0.2,0-0.3-0.1-0.5c1.1-3.5,1.5-7.3,2.5-10.9c1.4-5,4.7-10.2,9.8-11c2.5-0.4,5,0.4,7.4,1.2
			c4.4,1.4,9,2.9,12.7,5.7C305,575.8,307.8,580.3,307.3,584.9z M341.2,552.6c1.2,6.3,1.5,14.2-3.9,17.7c-3.6,2.3-8.1,1.6-12.4,1.4
			c-5.1-0.1-10.3,0.7-15.3-0.3c-3.8-0.7-7.6-3-9.4-6.2c-0.1-3.1,0-6.3,0.3-9.4c0-0.1,0-0.2,0-0.3c0.1-0.1,0.1-0.3,0.1-0.5
			c-0.1-1.1-0.2-2.2-0.3-3.3c0-0.1,0-0.2-0.1-0.3c0.6-4.5,2.1-9,4.6-12.8c0.7-1.1,1.5-2.3,1.8-3.6c0.6-0.4,1.2-0.9,1.7-1.5
			c0.4-0.4,0.5-0.9,0.9-1.4c0.6-0.8,1.3-1,2.1-1.5c0.7-0.5,1.1-1.1,1.5-1.7c1.1-0.9,1.8-1.6,3.3-2c0.2-0.1,0.4-0.2,0.5-0.3
			c6-1.7,12.9,1.3,17,6.2C338,538.3,339.8,545.5,341.2,552.6z M382.6,468.6c1.4,3.5,1.9,7.4,1.7,11.2c-0.4,6.3-2.8,12.4-5.4,18.2
			c-3.7,8.3-8.1,16.5-14.6,22.8c-6.5,6.3-15.6,10.5-24.6,9.4c-9-1.1-17.4-8.4-18-17.5c-0.4-6.1,2.6-11.7,4.5-17.5
			c2.8-8.4,3.4-17.4,6.4-25.7s9.3-16.4,18-17.6c6.4-0.9,12.7,2,18.6,4.8c2.4,1.2,4.8,2.3,7.2,3.5c0,0.1,0.1,0.1,0.1,0.2
			C378.5,463.1,380.6,465.9,382.6,468.6z M404.8,414.5c-1.5,2.8-3.3,5.4-4.7,8.2c-4.7,9.8-4,23-13,29c-5.7,3.8-13.4,2.9-19.9,0.8
			c-7.7-2.5-15.5-7.4-17.9-15.2c-3.1-10.3,4.3-22,0.1-31.9c-2.3-5.2-0.2-11.2,2.4-16.3c3.6-6.8,8.6-13.2,15.4-16.7
			c11.1-5.8,25.9-2.5,34.1,6.9S410.6,403.4,404.8,414.5z"/>
		<path id="XMLID_79_" fill="#010101" d="M76.3,413.6l0.3-0.2c-0.9-2.2-2.4-4.9-4.8-4.9c0.9,2.4,2.2,4.6,3.8,6.5
			C76.2,415.1,76.7,414.1,76.3,413.6z"/>
		<path id="XMLID_78_" fill="#010101" d="M366.2,207.5c1.4,0.5,3,0.2,4.2-0.8c-0.6-1.7-2.6-2.7-4.4-2.3c0.1-1.1-0.5-2.2-1.5-2.8
			c-0.6,2.1-0.9,4.3-0.9,6.5c0.8,0.2,1.8,0,2.4-0.7L366.2,207.5z"/>
		<path id="XMLID_77_" fill="#010101" d="M134,117.5c0.3,0,0.5-0.1,0.7-0.3c4.2-2.6,8.5-5.2,12.7-7.8c1.1-0.7,2.4-2.1,1.6-3.1
			c-5.6,1.8-10.7,4.9-14.9,8.9C133.4,115.9,133,117.4,134,117.5z"/>
		<path id="XMLID_76_" fill="#010101" d="M66.4,278.5c0.5-0.1,0.9-0.1,1.4-0.2c0.1-5.3,9.1-6.1,10.1-11.3c-1-0.4-2.2,0.3-3.1,0.9
			c-1.6,1.1-3.2,2.1-4.8,3.2c-1.3,0.9-2.6,1.8-3.5,3.1C65.7,275.4,65.5,277.3,66.4,278.5z"/>
		<path id="XMLID_75_" fill="#010101" d="M101.2,492c-1.5,0.6-3,1.2-4.5,1.8c-1.2,0.5-1.8,2-1.7,3.3s0.8,2.5,1.5,3.7
			c-0.2-1.3,1-2.7,2.3-2.7C99.6,496.1,100.4,494,101.2,492z"/>
		<path id="XMLID_74_" fill="#010101" d="M64.2,264.8c-4.4,3.1-8.4,6.7-11.7,10.9c3.8-1.2,7.4-3.2,10.3-6
			C64.2,268.5,65.5,266.2,64.2,264.8z"/>
		<path id="XMLID_72_" fill="#010101" d="M378.4,399.1c0.9-0.9,1.3-2.2,1.7-3.4c1.1-3.5,2.3-7,3.4-10.5c-2-0.6-3.7,1.6-4.6,3.5
			c-1.7,3.5-3,7.3-3.8,11.1C376.1,400.5,377.5,400,378.4,399.1z"/>
		<path id="XMLID_71_" fill="#010101" d="M372.2,251.4c1.3,2.2,2.7,4.5,3.1,7.1c0.4,2.6-0.3,5.5-2.4,7c0,1.3,2.2,1.1,2.9,0
			c0.7-1.1,0.8-2.7,1.9-3.4c0.5-0.3,1.1-0.4,1.6-0.8c0.4-0.4,0.5-1.1,0.6-1.7C380,255.4,376.3,251.5,372.2,251.4z"/>
		<path id="XMLID_69_" fill="#010101" d="M194.1,93.7c0.6-0.1,1.3-0.3,1.7-0.8c0.4-0.5,0.3-1.4-0.3-1.6c-5.5-1.9-12-0.5-16.3,3.4
			C184.2,95.1,189.2,94.7,194.1,93.7z"/>
		<path id="XMLID_68_" fill="#010101" d="M358.2,479.7c0.2-0.2,0.3-0.5,0.4-0.8c1.6-4,3.1-8.1,4.7-12.1c-1.2-0.9-3,0.3-3.5,1.8
			c-0.5,1.4-0.4,3.1-1.1,4.4c-0.5,1-1.4,1.8-2.1,2.6c-0.7,0.9-1.3,2-1,3.1S357.4,480.6,358.2,479.7z"/>
		<path id="XMLID_66_" fill="#010101" d="M58.2,407.8c-1.5-0.2-2.8,0.9-3.9,1.9c-0.9,0.8-1.8,1.7-2.6,2.5c-1,1-1.8,3.1-0.4,3.4
			c2.4-2,5-3.6,7.9-4.7C60.5,410.3,59.7,407.9,58.2,407.8z"/>
		<path id="XMLID_65_" fill="#010101" d="M381.6,281.6c-0.7,0.4-1.3,0.8-1.9,1.3c1.3-0.1,2.7,0.2,3.8,0.9c2.3,1.4,4.4,4.3,7,3.5
			C390.8,283.1,385.4,279.7,381.6,281.6z"/>
		<path id="XMLID_64_" fill="#010101" d="M262,97.4c-0.7-1.9-2.9-2.6-4.9-3.2c-2.7-0.7-5.5-1.5-8.2-2.2c-0.9-0.2-1.8-0.5-2.6-0.2
			c-0.8,0.3-1.5,1.3-1,2.1C250.7,91.9,256.3,98.7,262,97.4z"/>
		<path id="XMLID_63_" fill="#010101" d="M75.5,208.2c-1.7-0.1-4,0.9-3.4,2.4c5,0.3,9.9,1.9,14.1,4.5
			C85.2,210.7,80.1,208.5,75.5,208.2z"/>
		<path id="XMLID_62_" fill="#010101" d="M358.7,193c-1.7,1-2.3,3-2.7,4.9c-0.4,1.5-0.7,3-1.1,4.5c0.9,0.4,1.8-0.4,2.5-1.2
			c1.4-1.6,2.9-3.2,4.3-4.8c0.3-0.4,0.6-0.7,0.8-1.2C363.1,193.4,360.3,192,358.7,193z"/>
		<path id="XMLID_61_" fill="#010101" d="M86.9,492.7c2.8-4.6,3.3-10.5,1.3-15.5c-0.5-1.3-2.1-2.8-3.1-1.7
			c1.8,5.8,1.7,12.2-0.5,17.9C84.8,494.4,86.4,493.6,86.9,492.7z"/>
	</g>
</g>
</svg>
</div>
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
                    let selectedTeeth = closestToothChart.data('selectedTeeth') || [];

                    if ($(this).hasClass("selected")) {
                        // If the tooth is already selected, remove it from the array
                        selectedTeeth = selectedTeeth.filter(t => t != toothNumber);
                    } else {
                        // If it's not selected, add it to the array
                        selectedTeeth.push(toothNumber);
                    }

                    // Update the data-tooth attribute in the closestToothChart to store the updated array
                    closestToothChart.data('selectedTeeth', selectedTeeth);

                    // Toggle the selected class to change the color
                    $(this).toggleClass("selected");

                    updateInput(toothType, closestToothChart);
                }
            });

            function updateInput(toothType, closestToothChart) {
                let dataId = closestToothChart.data("id");
                let selectedTeeth = closestToothChart.data('selectedTeeth') || [];

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
