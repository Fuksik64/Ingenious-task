<?php

declare(strict_types=1);

namespace Modules\Invoice\Application\UseCase;

use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Exception\InvoiceNotFoundException;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoice\Domain\Validator\InvoiceStatusValidator;
use Modules\Notifications\Api\Dtos\NotifyData;
use Modules\Notifications\Api\NotificationFacadeInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class SendInvoiceHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private NotificationFacadeInterface $notificationFacade,
        private InvoiceStatusValidator $invoiceStatusValidator
    )
    {
    }

    public function execute(UuidInterface $uuid): void
    {
        $invoice = $this->invoiceRepository->findById($uuid);

        if ($invoice === null) {
            throw new InvoiceNotFoundException;
        }

        $this->invoiceStatusValidator->invoiceCanHaveSendingStatus($invoice);

        $notifyData = new NotifyData(
            resourceId: $invoice->getId(),
            toEmail: $invoice->getCustomerEmail(),
            subject: 'Invoice',
            message: 'Your invoice is ready'
        );

        $this->notificationFacade->notify($notifyData);

        $invoice->setStatus(StatusEnum::Sending);
        $this->invoiceRepository->update($invoice);

    }

}