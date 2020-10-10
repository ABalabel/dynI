<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function store()
    {

        Invoice::create($this->validateRequest());
    }

    public function update(Invoice $invoice)
    {
        $invoice->update($this->validateRequest());
    }
    /**
     * @return array
     */
    protected function validateRequest()
    {
        return \request()->validate([
            'serial' => 'required',
            'date' => 'required',
            'client' => 'required',
            'total' => '',
            'vat' => '',
            'grand_total' => '',
        ]);
    }
}
