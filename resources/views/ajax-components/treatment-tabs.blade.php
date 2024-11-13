@if (count($treatments) > 0)
    <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
        @foreach ($treatments as $treatment)
            <li class="nav-item tab-btn" data-needlab="{{ $treatment->treatmentType->need_labs }}"
                data-first="{{ $loop->first ? 1 : 0 }}">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    id="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}-tab" data-toggle="pill"
                    href="#{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}" role="tab"
                    aria-controls="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}"
                    aria-selected="true">{{ $treatment->treatmentType->name }}</a>
            </li>
        @endforeach
        <li class="nav-item tab-btn" data-needlab="0">
            <a class="nav-link" id="notes-tab" data-toggle="pill" href="#notes" role="tab" aria-controls="notes"
                aria-selected="false">Write Notes</a>
        </li>
    </ul>
    <div class="tab-content mb-1" id="pills-tabContent">
        @foreach ($treatments as $treatment)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}" role="tabpanel"
                aria-labelledby="{{ str_replace([' ', '.'], '_', $treatment->treatmentType->name) }}-tab">
                <div class="row">
                    @foreach ($treatment->treatmentType->sections as $section)
                        <div class="card-body col-6">
                            <h6>{{ $section->title }}</h6>
                            @if ($section->multi_selection)
                                @foreach ($section->attributes as $attribute)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" data-attr="{{ $attribute->id }}"
                                            data-id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}"
                                            class="checkbox-inp custom-control-input"
                                            id="{{ $section->id }}-{{ $attribute->id }}">
                                        <label class="custom-control-label"
                                            for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                    </div>
                                    @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                        <div class="mt-2 d-none"
                                            id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}">
                                            @foreach ($attribute->inputs as $input)
                                                <div class="form-group row">
                                                    <label for="{{ $input->id }}"
                                                        class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                            class="form-control attr-inputs {{ $treatment->treatmentType->need_labs ? 'lab-inputs' : '' }}"
                                                            id="{{ $input->id }}" data-name="{{ $input->name }}"
                                                            data-attr="{{ $attribute->id }}"
                                                            data-id="{{ $input->id }}" value="{{ $input->value }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($section->attributes as $attribute)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" data-attr="{{ $attribute->id }}"
                                            data-id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}"
                                            id="{{ $section->id }}-{{ $attribute->id }}" name="customRadio"
                                            class="custom-control-input">
                                        <label class="custom-control-label"
                                            for="{{ $section->id }}-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                    </div>
                                    @if ($attribute->has_inputs && count($attribute->inputs) > 0)
                                        <div class="mt-2 d-none {{ str_replace([' ', '.'], '_', $section->title) }}"
                                            id="{{ str_replace([' ', '.'], '_', $section->title) }}-{{ $attribute->id }}">
                                            @foreach ($attribute->inputs as $input)
                                                <div class="form-group row">
                                                    <label for="{{ $input->id }}"
                                                        class="col-sm-3 col-form-label">{{ $input->name }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                            class="form-control attr-inputs {{ $treatment->treatmentType->need_labs ? 'lab-inputs' : '' }}"
                                                            id="{{ $input->id }}" data-id="{{ $input->id }}"
                                                            data-name="{{ $input->name }}"
                                                            data-attr="{{ $attribute->id }}"
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
        @endforeach
        <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
            <h6>Write Notes</h6>
            <textarea name="" dir="auto" class="form-control" id="notes-inp" cols="30" rows="10"></textarea>
        </div>
    </div>

    <div id="lab-div" class="d-none p-2">
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input lab-done" id="cementation-delivery">
                <label class="custom-control-label" for="cementation-delivery">Done</label>
            </div> <!-- form-group -->
        </div>
        <h6>Lab Service</h6>
        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label for="select" class="d-block">Services</label>
                <select multiple class="form-control select2-multi lab-work d-block w-100" id="select"
                    autocomplete="off">
                    @foreach ($labsServices as $service)
                        <option value="{{ $service->name }}">{{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="simple-select">Labs</label>
                <select class="form-control select2 lab" id="simple-select">
                    <option value="">select lab</option>
                    @foreach ($labs as $lab)
                        <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                    @endforeach
                </select>
            </div> <!-- form-group -->
        </div>
        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label>Charges</label>
                <input type="number" class="form-control" min="0" id="cost"
                    autocomplete="new-password" step="100">
            </div> <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Date</label>
                <input type="date" class="form-control" id="sent">
            </div> <!-- form-group -->
        </div>
    </div>

@endif
