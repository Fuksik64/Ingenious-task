<?php

declare(strict_types=1);

namespace Invoice\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

final class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_invoice(): void
    {
        $response = $this->postJson(route('invoice.store'), [
                'customer_name' => 'John Doe',
                'customer_email' => 'test@email.com',
                'product_lines' => [
                    [
                        'name' => 'Product 1',
                        'price' => 100,
                        'quantity' => 1,
                    ],
                    [
                        'name' => 'Product 2',
                        'price' => 200,
                        'quantity' => 2,
                    ],
                ]
            ]
        );
        $response->assertCreated();
    }

    public function test_show_invoice(): void
    {
        $invoice = new Invoice(
            id: Uuid::uuid4(),
            status: StatusEnum::Draft,
            customerName: 'John Doe',
            customerEmail: 'test@example.com',
            invoiceProductLines: []
        );

        app(InvoiceRepositoryInterface::class)->save($invoice);

        $response = $this->getJson(route('invoice.show', ['invoice' => $invoice->getId()->toString()]));
        $response->assertOk();
    }

}