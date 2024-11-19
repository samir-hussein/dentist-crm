<?php

namespace App\Http\Services\Assistant;

use Illuminate\Http\Request;

class AssistantGetAllService extends AssistantService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "assistants", $request);
    }
}
