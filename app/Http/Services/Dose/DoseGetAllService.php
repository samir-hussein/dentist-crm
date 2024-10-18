<?php

namespace App\Http\Services\Dose;

use Illuminate\Http\Request;

class DoseGetAllService extends DoseService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "doses", $request);
    }
}
