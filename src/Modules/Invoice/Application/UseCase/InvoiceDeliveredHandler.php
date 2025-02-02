<?php

declare(strict_types=1);

namespace Modules\Invoice\Application\UseCase;

use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoice\Domain\Validator\InvoiceStatusValidator;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceDeliveredHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private InvoiceStatusValidator $invoiceStatusValidator
    )
    {
    }

    public function execute(UuidInterface $id): void
    {
        $invoice = $this->invoiceRepository->findById($id);
        if($invoice === null){
            return;
        }

        $this->invoiceStatusValidator->invoiceCanHaveSentToClientStatus($invoice);

        $invoice->setStatus(StatusEnum::SentToClient);
        $this->invoiceRepository->update($invoice);

    }

}