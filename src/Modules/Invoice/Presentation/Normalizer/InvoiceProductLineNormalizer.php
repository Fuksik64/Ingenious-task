<?php

declare(strict_types=1);

namespace Modules\Invoice\Presentation\Normalizer;

use Modules\Invoice\Domain\Entities\InvoiceProductLine;

final readonly class InvoiceProductLineNormalizer
{

    public function normalize(InvoiceProductLine $invoiceProductLine): array
    {
        return [
            'id' => $invoiceProductLine->getId()->toString(),
            'invoice_id' => $invoiceProductLine->getInvoiceId()->toString(),
            'name' => $invoiceProductLine->getName(),
            'quantity' => $invoiceProductLine->getQuantity(),
            'price' => $invoiceProductLine->getPrice(),
            'total' => $invoiceProductLine->getTotal(),
        ];
    }
}