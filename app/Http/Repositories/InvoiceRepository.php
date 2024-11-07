<?php

namespace App\Http\Repositories;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Interfaces\IInvoice;
use App\Http\Services\Invoice\InvoiceAllService;
use App\Http\Services\Invoice\InvoiceTaxService;
use App\Http\Services\Invoice\InvoiceIndexService;
use App\Http\Services\Invoice\InvoicePrintService;
use App\Http\Services\Invoice\InvoiceRemoveFromTaxService;

class InvoiceRepository implements IInvoice
{
    private $indexService;
    private $printService;
    private $taxService;
    private $removeFromTaxService;
    private $reportService;

    public function __construct(
        InvoiceIndexService $indexService,
        InvoicePrintService $printService,
        InvoiceTaxService $taxService,
        InvoiceRemoveFromTaxService $removeFromTaxService,
        InvoiceAllService $reportService
    ) {
        $this->indexService = $indexService;
        $this->printService = $printService;
        $this->taxService = $taxService;
        $this->removeFromTaxService = $removeFromTaxService;
        $this->reportService = $reportService;
    }

    public function index()
    {
        return $this->indexService->boot();
    }

    public function tax()
    {
        return $this->taxService->boot();
    }

    public function report()
    {
        return $this->reportService->boot();
    }

    public function print()
    {
        return $this->printService->boot();
    }

    public function removeFromTax(Invoice $invoice)
    {
        return $this->removeFromTaxService->boot($invoice);
    }
}
