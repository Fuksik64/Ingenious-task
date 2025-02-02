<?php

declare(strict_types=1);

namespace Modules\Invoice\Domain\Entities;

use Modules\Invoice\Domain\Enums\StatusEnum;
use Ramsey\Uuid\UuidInterface;

final class Invoice
{
    public function __construct(
        private UuidInterface $id,
        private StatusEnum $status,
        private string $customerName,
        private string $customerEmail,
        private array $invoiceProductLines,
    )
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getCustomerEmail(): string
    {
        return $this->customerEmail;
    }

    /**
     * @return InvoiceProductLine[]
     */
    public function getInvoiceProductLines(): array
    {
        return $this->invoiceProductLines;
    }

    public function getTotal(): int
    {
        return array_reduce($this->invoiceProductLines, fn($acc, InvoiceProductLine $line) => $acc + $line->getTotal(), 0);
    }

    public function addInvoiceProductLine(InvoiceProductLine $invoiceProductLine): void
    {
        $this->invoiceProductLines[] = $invoiceProductLine;
    }


}