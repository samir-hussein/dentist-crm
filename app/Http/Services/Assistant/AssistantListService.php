<?php

namespace App\Http\Services\Assistant;

use Illuminate\Http\Request;

class AssistantListService extends AssistantService
{
    public function boot()
    {
        // Fetch all columns from your model's table
        return $this->model->all();
    }
}
