@if (count($treatments) > 0)
    <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
        @foreach ($treatments as $treatment)
            @if ($loop->first)
                <li class="nav-item">
                    <a class="nav-link active" id="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}-tab"
                        data-toggle="pill" href="#{{ str_replace(' ', '-', $treatment->treatmentType->name) }}"
                        role="tab" aria-controls="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}"
                        aria-selected="true">{{ $treatment->treatmentType->name }}</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" id="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}-tab"
                        data-toggle="pill" href="#{{ str_replace(' ', '-', $treatment->treatmentType->name) }}"
                        role="tab" aria-controls="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}"
                        aria-selected="false">{{ $treatment->treatmentType->name }}</a>
                </li>
            @endif
        @endforeach
        <li class="nav-item">
            <a class="nav-link" id="notes-tab" data-toggle="pill" href="#notes" role="tab" aria-controls="notes"
                aria-selected="false">Write Notes</a>
        </li>
    </ul>
    <div class="tab-content mb-1" id="pills-tabContent">
        @foreach ($treatments as $treatment)
            @if ($loop->first)
                <div class="tab-pane fade show active" id="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}"
                    role="tabpanel" aria-labelledby="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}-tab">
                    <div class="row">
                        @foreach ($treatment->treatmentType->sections as $section)
                            <div class="card-body col-12 col-md-6">
                                <h6>{{ $section->title }}</h6>
                                @if ($section->multi_selection)
                                    @foreach ($section->attributes as $attribute)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="{{ $section->id }}-{{ $attribute->id }}">
                                            <label class="custom-control-label"
                                                for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                        </div>
                                        @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                            <div class="mt-2 d-none">
                                                @foreach ($attribute->inputs as $input)
                                                    <div class="form-group row">
                                                        <label for="{{ $input->id }}"
                                                            class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                id="{{ $input->id }}" value="{{ $input->value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($section->attributes as $attribute)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="{{ $section->id }}-{{ $attribute->id }}"
                                                name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                        </div>
                                        @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                            <div class="mt-2 d-none">
                                                @foreach ($attribute->inputs as $input)
                                                    <div class="form-group row">
                                                        <label for="{{ $input->id }}"
                                                            class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                id="{{ $input->id }}" value="{{ $input->value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="tab-pane fade" id="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}"
                    role="tabpanel" aria-labelledby="{{ str_replace(' ', '-', $treatment->treatmentType->name) }}-tab">
                    <div class="row">
                        @foreach ($treatment->treatmentType->sections as $section)
                            <div class="card-body col-12 col-md-6">
                                <h6>{{ $section->title }}</h6>

                                @if ($section->multi_selection)
                                    @foreach ($section->attributes as $attribute)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="{{ $section->id }}-{{ $attribute->id }}">
                                            <label class="custom-control-label"
                                                for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                        </div>
                                        @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                            <div class="mt-2 d-none">
                                                @foreach ($attribute->inputs as $input)
                                                    <div class="form-group row">
                                                        <label for="{{ $input->id }}"
                                                            class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                id="{{ $input->id }}" value="{{ $input->value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($section->attributes as $attribute)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="{{ $section->id }}-{{ $attribute->id }}"
                                                name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label"
                                                for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                        </div>
                                        @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                            <div class="mt-2 d-none">
                                                @foreach ($attribute->inputs as $input)
                                                    <div class="form-group row">
                                                        <label for="{{ $input->id }}"
                                                            class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                id="{{ $input->id }}"
                                                                value="{{ $input->value }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
            <h6>Write Notes</h6>
            <textarea name="" dir="auto" class="form-control" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
@endif
