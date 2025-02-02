<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Mapper;

use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Infrastructure\Model\Invoice as InvoiceModel;
use Modules\Invoice\Infrastructure\Model\InvoiceProductLine as InvoiceProductLineModel;

final readonly class EloquentInvoiceToEntityMapper
{
    public function __construct(
        private EloquentInvoiceProductLineToEntityMapper $eloquentInvoiceProductLineToEntityMapper
    )
    {

    }

    public function map(InvoiceModel $invoice): Invoice
    {

        if ($invoice->relationLoaded('invoiceProductLines')) {
            $invoiceProductLines = $invoice->invoiceProductLines->map(
                fn(InvoiceProductLineModel $invoiceProductLine) => $this->eloquentInvoiceProductLineToEntityMapper->map($invoiceProductLine)
            )->toArray();
        } else {
            $invoiceProductLines = [];
        }

        return new Invoice(
            $invoice->id,
            $invoice->status,
            $invoice->customer_name,
            $invoice->customer_email,
            $invoiceProductLines,
        );

    }

}