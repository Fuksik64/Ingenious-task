<?php

declare(strict_types=1);

namespace Modules\Invoice\Application\Api\Dtos;

final readonly class InvoiceDto
{
    public function __construct(
        public string $customerName,
        public string $customerEmail,
        /** @var InvoiceProductLineDto[] */
        public array $invoiceProductLines,
    )
    {

    }
}