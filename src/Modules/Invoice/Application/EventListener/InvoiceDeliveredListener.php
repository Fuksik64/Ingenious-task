<?php

declare(strict_types=1);

namespace Modules\Invoice\Application\EventListener;

use Modules\Invoice\Application\UseCase\InvoiceDeliveredHandler;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;

final readonly class InvoiceDeliveredListener
{

    public function __construct(
        private InvoiceDeliveredHandler $invoiceDeliveredHandler,
    )
    {
    }

    public function handle(ResourceDeliveredEvent $event): void
    {
        $this->invoiceDeliveredHandler->execute($event->resourceId);
    }
}