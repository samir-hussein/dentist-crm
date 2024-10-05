<?php

namespace App\Http\Services\Staff;

use Illuminate\Http\Request;

class StaffGetAllService extends StaffService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->where("is_admin", false)->latest()->select('*');

        return $this->dataTable($data, "users", $request);
    }
}
