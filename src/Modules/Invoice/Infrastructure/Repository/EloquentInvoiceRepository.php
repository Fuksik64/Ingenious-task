<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Repository;

use Modules\Invoice\Domain\Entities\Invoice;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoice\Infrastructure\Mapper\EloquentInvoiceToEntityMapper;
use Modules\Invoice\Infrastructure\Model\Invoice as InvoiceModel;
use Ramsey\Uuid\UuidInterface;

final readonly class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private EloquentInvoiceToEntityMapper $eloquentInvoiceToEntityMapper
    )
    {
    }

    public function findById(UuidInterface $id): ?Invoice
    {
        $data = InvoiceModel::query()->with('invoiceProductLines')->find($id);
        if ($data === null) {
            return null;
        }
        return $this->eloquentInvoiceToEntityMapper->map($data);
    }

    public function save(Invoice $invoice): void
    {
        InvoiceModel::create(
            [
                'id' => $invoice->getId(),
                'customer_name' => $invoice->getCustomerName(),
                'customer_email' => $invoice->getCustomerEmail(),
                'status' => $invoice->getStatus(),
            ]
        );
    }

    public function update(Invoice $invoice): void
    {
        $invoiceModel = InvoiceModel::find($invoice->getId());
        $invoiceModel->customer_name = $invoice->getCustomerName();
        $invoiceModel->customer_email = $invoice->getCustomerEmail();
        $invoiceModel->status = $invoice->getStatus();
        $invoiceModel->save();
    }

}