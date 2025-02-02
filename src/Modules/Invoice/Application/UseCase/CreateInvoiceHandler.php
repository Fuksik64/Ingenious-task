<?php

declare(strict_types=1);

namespace Modules\Invoice\Application\UseCase;

use Modules\Invoice\Application\Api\Dtos\InvoiceDto;
use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Entities\InvoiceProductLine;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Domain\Repository\InvoiceProductLineRepositoryInterface;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Ramsey\Uuid\Uuid;

final readonly class CreateInvoiceHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private InvoiceProductLineRepositoryInterface $invoiceProductLineRepository

    )
    {
    }

    public function execute(InvoiceDto $dto): Invoice
    {

        $entity = new Invoice(
            id: Uuid::uuid4(),
            status: StatusEnum::Draft,
            customerName: $dto->customerName,
            customerEmail: $dto->customerEmail,
            invoiceProductLines: [],
        );
        $this->invoiceRepository->save($entity);

        foreach ($dto->invoiceProductLines as $productLine) {
            $productLine = new InvoiceProductLine(
                id: Uuid::uuid4(),
                invoiceId: $entity->getId(),
                productName: $productLine->name,
                quantity: $productLine->quantity,
                price: $productLine->price,
            );

            $entity->addInvoiceProductLine($productLine);
            $this->invoiceProductLineRepository->save($productLine);
        }

        return $entity;
    }

}