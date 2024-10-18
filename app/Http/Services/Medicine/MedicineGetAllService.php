<?php

namespace App\Http\Services\Medicine;

use Illuminate\Http\Request;

class MedicineGetAllService extends MedicineService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->with("medicineType")->select('*');

        if ($request->has("searchKey") && trim($request->searchKey) != "") {
            $data->whereHas('medicineType', function ($query) use ($request) {
                $query->where('name', $request->searchKey);
            });
        }

        return $this->dataTableForMedicine($data, "medicines", $request);
    }
}
