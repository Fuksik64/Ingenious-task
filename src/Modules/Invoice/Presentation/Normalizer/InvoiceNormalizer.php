<?php

declare(strict_types=1);

namespace Modules\Invoice\Presentation\Normalizer;

use Modules\Invoice\Domain\Entities\Invoice;

final readonly class InvoiceNormalizer
{
    public function __construct(private InvoiceProductLineNormalizer $invoiceProductLineNormalizer)
    {
    }

    public function normalize(Invoice $invoice): array
    {
        $productLines = array_map(
            fn($productLine) => $this->invoiceProductLineNormalizer->normalize($productLine),
            $invoice->getInvoiceProductLines()
        );

        return [
            'id' => $invoice->getId()->toString(),
            'status' => $invoice->getStatus(),
            'customer_name' => $invoice->getCustomerName(),
            'customer_email' => $invoice->getCustomerEmail(),
            'product_lines' => $productLines,
            'total' => $invoice->getTotal(),
        ];

    }

}