<?php

namespace App\Http\Interfaces;

use App\Models\Invoice;
use Illuminate\Http\Request;

interface IInvoice
{
    public function index();
    public function tax();
    public function report();
    public function print();
    public function removeFromTax(Invoice $invoice);
}
