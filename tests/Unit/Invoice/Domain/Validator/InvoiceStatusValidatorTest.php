<?php

declare(strict_types=1);

namespace Invoice\Domain\Validator;

use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Exception\CantChangeInvoiceStatusException;
use Modules\Invoice\Domain\Validator\InvoiceStatusValidator;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

final class InvoiceStatusValidatorTest extends TestCase
{

    public function test_invoice_can_have_status_sending_only_when_status_is_draft(): void
    {
        $invoice = new Invoice(
            id: Uuid::uuid4(),
            status: StatusEnum::Draft,
            customerName: 'John Doe',
            customerEmail: 'test@example.com',
            invoiceProductLines: []
        );


        $validator = app(InvoiceStatusValidator::class);
        $validator->invoiceCanHaveSendingStatus($invoice);

        $invoice->setStatus(StatusEnum::Sending);
        $this->expectException(CantChangeInvoiceStatusException::class);
        $validator->invoiceCanHaveSendingStatus($invoice);
    }

    public function test_invoice_can_have_status_sent_only_when_current_status_is_sending(): void
    {
        $invoice = new Invoice(
            id: Uuid::uuid4(),
            status: StatusEnum::Sending,
            customerName: 'John Doe',
            customerEmail: 'test@example.com',
            invoiceProductLines: []
        );


        $validator = app(InvoiceStatusValidator::class);
        $validator->invoiceCanHaveSentToClientStatus($invoice);

        $invoice->setStatus(StatusEnum::SentToClient);
        $this->expectException(CantChangeInvoiceStatusException::class);
        $validator->invoiceCanHaveSendingStatus($invoice);

    }
}