<?php

namespace App\Http\Services\Branch;

class BranchListService extends BranchService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
