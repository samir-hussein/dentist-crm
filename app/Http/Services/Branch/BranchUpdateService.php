<?php

namespace App\Http\Services\Branch;

use App\Models\Branch;

class BranchUpdateService extends BranchService
{
    public function boot(Branch $branch, array $data)
    {
        $branch->update($data);

        return $this->success();
    }
}
