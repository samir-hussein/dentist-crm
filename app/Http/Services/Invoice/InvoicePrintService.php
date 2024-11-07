<?php

namespace App\Http\Services\Invoice;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;

class InvoicePrintService extends InvoiceService
{
    public function boot()
    {
        $request = request();

        $invoice = $request->invoice;
        $patient = $request->patient;
        $tooth = $request->tooth;
        $tax = $request->tax;

        $data = Invoice::where('patient_id', $patient);

        // Apply filters if any
        if ($tooth && $tooth != "") {
            $data->where('tooth', $tooth);
        }

        if ($invoice && $invoice != "") {
            $invoice = Invoice::find($invoice);

            if ($invoice) {
                $data->where('treatment_detail_id', $invoice->treatment_detail_id);
            }
        }

        if ($tax && $tax == 1) {
            $data->update([
                'tax_invoice' => 1
            ]);
        }

        $data = $data->get();

        return view("ajax-components.invoices", ["data" => $data])->render();
    }
}
