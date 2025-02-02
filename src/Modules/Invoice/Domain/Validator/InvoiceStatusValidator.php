<?php

declare(strict_types=1);

namespace Modules\Invoice\Domain\Validator;

use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Exception\CantChangeInvoiceStatusException;

final readonly class InvoiceStatusValidator
{
    public function invoiceCanHaveSentToClientStatus(Invoice $invoice): void
    {
        if ($invoice->getStatus() === StatusEnum::Sending) {
            return;
        }
        throw new CantChangeInvoiceStatusException();
    }

    public function invoiceCanHaveSendingStatus(Invoice $invoice): void
    {
        if ($invoice->getStatus() === StatusEnum::Draft) {
            return;
        }
        throw new CantChangeInvoiceStatusException();
    }

}