<?php

namespace App\Http\Services\Invoice;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
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

        if ($request->from && $request->from != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->from / 1000;
            $from = Carbon::createFromTimestamp($timestamp)->startOfDay(); // Set to 00:00:00 of the given date
            $data->where('created_at', '>=', $from);
        }

        if ($request->to && $request->to != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->to / 1000;
            $to = Carbon::createFromTimestamp($timestamp)->endOfDay(); // Set to 23:59:59 of the given date
            $data->where('created_at', '<=', $to);
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
