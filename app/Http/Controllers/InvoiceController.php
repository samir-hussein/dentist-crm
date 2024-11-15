<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IDoctor;
use App\Http\Interfaces\IInvoice;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $service;

    public function __construct(IInvoice $invoiceRepository, private IDoctor $doctorService)
    {
        $this->service = $invoiceRepository;
    }

    /**
     * Get a listing of the resource.
     */
    public function all()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Get a listing of the resource.
     */
    public function tax()
    {
        $data = $this->service->tax();

        return $data;
    }

    /**
     * Get a listing of the resource.
     */
    public function report()
    {
        $data = $this->service->report();

        return $data;
    }

    /**
     * Get a listing of the resource.
     */
    public function index()
    {
        $data = $this->doctorService->listService();
        return view("invoices", ['doctors' => $data]);
    }

    /**
     * Get a listing of the resource.
     */
    public function taxReport()
    {
        $data = $this->doctorService->listService();
        return view("tax-invoices", ['doctors' => $data]);
    }

    public function removeFromTax(Invoice $invoice)
    {
        $this->service->removeFromTax($invoice);

        return $this->backWithSuccess();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function print()
    {
        $data = $this->service->print();

        return response()->json([
            "html" => $data
        ]);
    }
}
