<?php

namespace App\Http\Services\TreatmentType;

use Illuminate\Support\Arr;
use App\Models\TreatmentType;

class TreatmentTypeUpdateService extends TreatmentTypeService
{
    public function boot(TreatmentType $treatmentType, array $data)
    {
        $treatmentType->update($data);
        $treatmentType->diagnosis()->delete();

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

        // Prepare updated section titles
        $updatedSectionTitles = Arr::pluck($sections, 'title');

        $treatmentType->sections()->whereNotIn('title', $updatedSectionTitles)->delete();

        foreach ($sections as $section) {
            $attributes = $section['attributes'];

            $check = $treatmentType->sections()->where([
                "title" => $section['title'],
                "treatment_type_id" => $treatmentType->id,
            ])->count();

            if ($check > 1) {
                $treatmentType->sections()->where([
                    "title" => $section['title'],
                    "treatment_type_id" => $treatmentType->id,
                ])->limit(1)->delete();
            }

            $section = $treatmentType->sections()->updateOrCreate([
                "title" => $section['title'],
                "treatment_type_id" => $treatmentType->id,
            ], $section);

            // Prepare updated attribute names
            $updatedAttributeNames = Arr::pluck($attributes, 'name');

            // Delete attributes that are not in the updated data
            $section->attributes()->whereNotIn('name', $updatedAttributeNames)->delete();

            foreach ($attributes as $attribute) {
                $inputs = isset($attribute['inputs']) ? $attribute['inputs'] : null;
                if ($inputs) {
                    $attribute['has_inputs'] = true;
                }

                $check = $section->attributes()->where([
                    "name" => $attribute['name'],
                    "treatment_section_id" => $section->id
                ])->count();

                if ($check > 1) {
                    $section->attributes()->where([
                        "name" => $attribute['name'],
                        "treatment_section_id" => $section->id
                    ])->limit(1)->delete();
                }

                $attribute = $section->attributes()->updateOrCreate([
                    "name" => $attribute['name'],
                    "treatment_section_id" => $section->id
                ], $attribute);

                // Prepare updated input names
                $updatedInputNames = $inputs ? Arr::pluck($inputs, 'name') : [];

                // Delete inputs that are not in the updated data
                $attribute->inputs()->whereNotIn('name', $updatedInputNames)->delete();

                if ($inputs && count($inputs) > 0) {
                    foreach ($inputs as $input) {
                        $check = $attribute->inputs()->where([
                            "name" => $input['name'],
                            "treatment_section_attribute_id" => $attribute->id,
                        ])->count();

                        if ($check > 1) {
                            $attribute->inputs()->where([
                                "name" => $input['name'],
                                "treatment_section_attribute_id" => $attribute->id,
                            ])->limit(1)->delete();
                        }

                        $input = $attribute->inputs()->updateOrCreate([
                            "name" => $input['name'],
                            "treatment_section_attribute_id" => $attribute->id,
                        ], $input);
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
