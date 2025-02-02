<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Repository;

use Modules\Invoice\Domain\Entities\InvoiceProductLine;
use Modules\Invoice\Domain\Repository\InvoiceProductLineRepositoryInterface;
use Modules\Invoice\Infrastructure\Model\InvoiceProductLine as InvoiceProductLineModel;

final readonly class EloquentInvoiceProductLineRepository implements InvoiceProductLineRepositoryInterface
{
    public function save(InvoiceProductLine $invoiceProductLine): void
    {
        InvoiceProductLineModel::create(
            [
                'id' => $invoiceProductLine->getId(),
                'invoice_id' => $invoiceProductLine->getInvoiceId(),
                'name' => $invoiceProductLine->getName(),
                'quantity' => $invoiceProductLine->getQuantity(),
                'price' => $invoiceProductLine->getPrice(),
            ]
        );
    }


}