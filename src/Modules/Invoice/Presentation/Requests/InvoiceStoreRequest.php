<?php

declare(strict_types=1);

namespace Modules\Invoice\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class InvoiceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string'],
            'customer_email' => ['required', 'email'],
            'product_lines' => ['present', 'array'],
            'product_lines.*.name' => ['required', 'string'],
            'product_lines.*.price' => ['required', 'numeric'],
            'product_lines.*.quantity' => ['required', 'numeric'],
        ];
    }
}
