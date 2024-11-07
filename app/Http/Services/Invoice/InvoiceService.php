<?php

namespace App\Http\Services\Invoice;

use App\Http\Services\BaseService;
use App\Models\Invoice;

class InvoiceService extends BaseService
{
    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }
}
