<?php

namespace App\Http\Services\Branch;

use Illuminate\Http\Request;

class BranchGetAllService extends BranchService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "branches", $request);
    }
}
