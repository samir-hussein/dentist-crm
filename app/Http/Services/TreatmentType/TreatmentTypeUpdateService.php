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

        // Get existing section titles
        $existingSections = $treatmentType->sections()->pluck('id', 'title')->toArray();

        // Prepare updated section titles
        $updatedSectionTitles = Arr::pluck($sections, 'title');

        $sectionsToDelete = array_diff(array_keys($existingSections), $updatedSectionTitles);

        $treatmentType->sections()->whereIn('title', $sectionsToDelete)->delete();

        foreach ($sections as $section) {
            $attributes = $section['attributes'];

            $section = $treatmentType->sections()->updateOrCreate([
                "title" => $section['title'],
                "treatment_type_id" => $treatmentType->id,
            ], $section);

            $existingAttributes = $section->attributes()->pluck('id', 'name')->toArray();

            // Prepare updated attribute names
            $updatedAttributeNames = Arr::pluck($attributes, 'name');

            // Find attributes to delete
            $attributesToDelete = array_diff(array_keys($existingAttributes), $updatedAttributeNames);

            // Delete attributes that are not in the updated data
            $section->attributes()->whereIn('name', $attributesToDelete)->delete();

            foreach ($attributes as $attribute) {
                $inputs = isset($attribute['inputs']) ? $attribute['inputs'] : null;
                if ($inputs) {
                    $attribute['has_inputs'] = true;
                }

                $attribute = $section->attributes()->updateOrCreate([
                    "name" => $attribute['name'],
                    "treatment_section_id" => $section->id
                ], $attribute);

                // Get existing input names for the attribute
                $existingInputs = $attribute->inputs()->pluck('id', 'name')->toArray();

                // Prepare updated input names
                $updatedInputNames = $inputs ? Arr::pluck($inputs, 'name') : [];

                // Find inputs to delete
                $inputsToDelete = array_diff(array_keys($existingInputs), $updatedInputNames);

                // Delete inputs that are not in the updated data
                $attribute->inputs()->whereIn('name', $inputsToDelete)->delete();

                if ($inputs && count($inputs) > 0) {
                    foreach ($inputs as $input) {
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
