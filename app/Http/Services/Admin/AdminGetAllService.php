<?php

namespace App\Http\Services\Admin;

use Illuminate\Http\Request;

class AdminGetAllService extends AdminService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->where("is_admin", true)->latest()->select('*');

        return $this->dataTable($data, "users", $request);
    }
}
