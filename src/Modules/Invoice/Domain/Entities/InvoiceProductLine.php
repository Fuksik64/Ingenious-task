<?php

declare(strict_types=1);

namespace Modules\Invoice\Domain\Entities;

use Ramsey\Uuid\UuidInterface;

final class InvoiceProductLine
{
    public function __construct(
        private UuidInterface $id,
        private UuidInterface $invoiceId,
        private string $productName,
        private int $quantity,
        private int $price,
    )
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getInvoiceId(): UuidInterface
    {
        return $this->invoiceId;
    }

    public function getName(): string
    {
        return $this->productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getTotal(): int
    {
        return $this->quantity * $this->price;
    }
}