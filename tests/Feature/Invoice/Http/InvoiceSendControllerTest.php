<?php

declare(strict_types=1);

namespace Invoice\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

final class InvoiceSendControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_can_be_send(): void
    {
        $invoice = new Invoice(
            id: Uuid::uuid4(),
            status: StatusEnum::Draft,
            customerName: 'John Doe',
            customerEmail: 'test@example.com',
            invoiceProductLines: []
        );

        app(InvoiceRepositoryInterface::class)->save($invoice);

        $response = $this->postJson(route('invoice.send.store', ['invoice' => $invoice->getId()->toString()]));
        $response->assertOk();

        $invoice = app(InvoiceRepositoryInterface::class)->findById($invoice->getId());
        $this->assertEquals(StatusEnum::Sending, $invoice->getStatus());
    }

}