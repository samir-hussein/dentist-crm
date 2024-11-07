<?php

namespace App\Http\Services\Invoice;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class InvoiceRemoveFromTaxService extends InvoiceService
{
    public function boot(Model $model)
    {
        Invoice::where("treatment_detail_id", $model->treatment_detail_id)->update([
            'tax_invoice' => 0
        ]);

        return $this->success();
    }
}
