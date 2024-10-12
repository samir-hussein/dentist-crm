<?php

namespace App\Http\Services\TreatmentType;

class TreatmentTypeStoreService extends TreatmentTypeService
{
    public function boot(array $data)
    {
        $treatmentType = $this->model->create($data);

        // Recursively remove numeric keys from sections and attributes
        $data['sections'] = collect($data['sections'])->map(function ($section) {
            // Remove numeric keys from attributes
            $section['attributes'] = collect($section['attributes'])->map(function ($attribute) {
                if (isset($attribute['inputs'])) {
                    // Remove numeric keys from inputs if they exist
                    $attribute['inputs'] = array_values($attribute['inputs']);
                }
                return $attribute;
            })->values()->all();

            return $section;
        })->values()->all();

        $sections = $data['sections'];

        foreach ($sections as $section) {
            $attributes = $section['attributes'];
            $section = $treatmentType->sections()->create($section);

            foreach ($attributes as $attribute) {
                $inputs = isset($attribute['inputs']) ? $attribute['inputs'] : null;
                if ($inputs) {
                    $attribute['has_inputs'] = true;
                }
                $attribute = $section->attributes()->create($attribute);

                if ($inputs && count($inputs) > 0) {
                    foreach ($inputs as $input) {
                        $input = $attribute->inputs()->create($input);
                    }
                }
            }
        }

        $diagnosis = array_map(function ($diagnosis_id) use ($treatmentType) {
            return [
                'diagnosis_id' => $diagnosis_id,
                'treatment_type_id' => $treatmentType->id
            ];
        }, $data['diagnosis_ids']);

        $treatmentType->diagnosis()->insert($diagnosis);
    }
}
