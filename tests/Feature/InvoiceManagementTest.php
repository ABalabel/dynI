<?php

namespace Tests\Feature;

use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_invoice_can_be_created()
    {
       $response = $this->post('/invoices/new', $this->getData());

       $response->assertOk();
       $this->assertCount(1, Invoice::all());
    }

    /** @test */
    public function a_serial_is_required()
    {
        $response = $this->post('/invoices/new', array_merge($this->getData(), ['serial' => '']));
        $response->assertSessionHasErrors('serial');
    }

    /** @test */
    public function a_date_is_required()
    {
        $response = $this->post('/invoices/new', array_merge($this->getData(), ['date' => '']));
        $response->assertSessionHasErrors('date');
    }

    /** @test */
    public function a_client_is_required()
    {
        $response = $this->post('/invoices/new', array_merge($this->getData(), ['client' => '']));
        $response->assertSessionHasErrors('client');
    }

    /** @test */
    public function an_invoice_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('/invoices/new', $this->getData());

        $invoice = Invoice::first();

        $response = $this->patch('/invoices/update/'. $invoice->id, array_merge($this->getData(), ['client' => 'AMB-Studios', 'date'=>'09-10-2020']));

        $this->assertEquals('AMB-Studios', $invoice->fresh()->client);
        $this->assertEquals('09-10-2020', $invoice->fresh()->date);
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return [
            'serial' => 123,
            'date' => '10-10-2020',
            'client' => 'JWT',
            'total' => 1000,
            'vat' => 140,
            'grand_total' => 1140,
        ];
    }
}
