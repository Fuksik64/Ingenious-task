<?php

declare(strict_types=1);

namespace Invoice\Application\EventListener;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

final class InvoiceDeliveredListenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_status_is_changed_when_notification_from_hook_is_received(): void
    {
        $invoice = new Invoice(
            id: Uuid::uuid4(),
            status: StatusEnum::Sending,
            customerName: 'John Doe',
            customerEmail: 'test@example.com',
            invoiceProductLines: []
        );
        app(InvoiceRepositoryInterface::class)->save($invoice);

        app(Dispatcher::class)->dispatch(new ResourceDeliveredEvent($invoice->getId()));

        $invoice = app(InvoiceRepositoryInterface::class)->findById($invoice->getId());
        $this->assertSame(StatusEnum::SentToClient, $invoice->getStatus());
    }

}