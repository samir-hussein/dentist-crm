<?php

namespace App\Http\Services\Branch;

use App\Models\Branch;

class BranchFindByIdService extends BranchService
{
    public function boot(Branch $branch)
    {
        return $branch;
    }
}
