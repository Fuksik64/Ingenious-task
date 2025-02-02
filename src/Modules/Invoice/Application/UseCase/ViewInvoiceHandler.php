<?php

declare(strict_types=1);

namespace Modules\Invoice\Application\UseCase;

use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class ViewInvoiceHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository
    )
    {
    }

    public function execute(UuidInterface $uuid): ?Invoice
    {
        return $this->invoiceRepository->findById($uuid);
    }

}