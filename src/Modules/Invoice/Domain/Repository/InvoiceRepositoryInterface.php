<?php

declare(strict_types=1);

namespace Modules\Invoice\Domain\Repository;

use Modules\Invoice\Domain\Entities\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{

    public function findById(UuidInterface $id): ?Invoice;

    public function save(Invoice $invoice): void;

    public function update(Invoice $invoice): void;

}