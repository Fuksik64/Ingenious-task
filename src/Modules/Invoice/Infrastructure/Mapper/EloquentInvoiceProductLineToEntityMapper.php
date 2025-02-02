<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Mapper;

use Modules\Invoice\Domain\Entities\InvoiceProductLine;
use Modules\Invoice\Infrastructure\Model\InvoiceProductLine as InvoiceProductLineModel;

final readonly class EloquentInvoiceProductLineToEntityMapper
{

    public function map(InvoiceProductLineModel $invoiceProductLine): InvoiceProductLine
    {

        return new InvoiceProductLine(
            $invoiceProductLine->id,
            $invoiceProductLine->invoice_id,
            $invoiceProductLine->name,
            $invoiceProductLine->quantity,
            $invoiceProductLine->price
        );


    }

}