<?php

declare(strict_types=1);

namespace Modules\Invoice\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Invoice\Application\Api\Dtos\InvoiceDto;
use Modules\Invoice\Application\Api\Dtos\InvoiceProductLineDto;
use Modules\Invoice\Application\UseCase\CreateInvoiceHandler;
use Modules\Invoice\Application\UseCase\ViewInvoiceHandler;
use Modules\Invoice\Presentation\Normalizer\InvoiceNormalizer;
use Modules\Invoice\Presentation\Requests\InvoiceStoreRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final readonly class InvoiceController
{
    public function __construct(
        private CreateInvoiceHandler $createInvoiceHandler,
        private ViewInvoiceHandler $viewInvoiceHandler,
        private InvoiceNormalizer $invoiceNormalizer
    )
    {
    }

    public function store(InvoiceStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $invoiceProductLines = array_map(fn(array $line) => new InvoiceProductLineDto(
            name: $line['name'],
            quantity: $line['quantity'],
            price: $line['price'],
        ),
            $data['product_lines']
        );

        $dto = new InvoiceDto(
            customerName: $data['customer_name'],
            customerEmail: $data['customer_email'],
            invoiceProductLines: $invoiceProductLines
        );

        $entity = $this->createInvoiceHandler->execute($dto);

        return response()->json($this->invoiceNormalizer->normalize($entity), Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $invoice = $this->viewInvoiceHandler->execute(Uuid::fromString($id));

        if ($invoice === null) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->invoiceNormalizer->normalize($invoice), Response::HTTP_OK);
    }
}
