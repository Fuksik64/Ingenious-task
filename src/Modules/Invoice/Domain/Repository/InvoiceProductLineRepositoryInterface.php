<?php

declare(strict_types=1);

namespace Modules\Invoice\Domain\Repository;

use Modules\Invoice\Domain\Entities\InvoiceProductLine;
use Ramsey\Uuid\UuidInterface;

interface InvoiceProductLineRepositoryInterface
{
    public function save(InvoiceProductLine $invoiceProductLine): void;

}