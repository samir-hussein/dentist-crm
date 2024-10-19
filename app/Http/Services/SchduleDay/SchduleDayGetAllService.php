<?php

namespace App\Http\Services\SchduleDay;

use Illuminate\Http\Request;

class SchduleDayGetAllService extends SchduleDayService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "schdule_days", $request);
    }
}
