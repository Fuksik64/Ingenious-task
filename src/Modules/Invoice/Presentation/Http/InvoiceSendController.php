<?php

declare(strict_types=1);

namespace Modules\Invoice\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Invoice\Application\UseCase\SendInvoiceHandler;
use Modules\Invoice\Domain\Exception\InvoiceNotFoundException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final readonly class InvoiceSendController
{
    public function __construct(
        private SendInvoiceHandler $sendInvoiceHandler
    )
    {
    }

    public function store(string $invoiceId): JsonResponse
    {
        try {
            $this->sendInvoiceHandler->execute(Uuid::fromString($invoiceId));
        } catch (InvoiceNotFoundException $e) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(null, Response::HTTP_OK);
    }

}
