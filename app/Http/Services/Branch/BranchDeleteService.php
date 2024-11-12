<?php

namespace App\Http\Services\Branch;

use App\Models\Branch;

class BranchDeleteService extends BranchService
{
    public function boot(Branch $branch)
    {
        $branch->delete();

        return $this->success();
    }
}
