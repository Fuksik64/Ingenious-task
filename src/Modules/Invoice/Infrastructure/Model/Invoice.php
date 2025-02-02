<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Invoice\Domain\Enums\StatusEnum;
use Modules\Invoice\Infrastructure\Cast\UuidCast;

final class Invoice extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    public $keyType = 'string';
    protected $casts
        = [
            'id' => UuidCast::class,
            'status' => StatusEnum::class
        ];

    public function invoiceProductLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class, 'invoice_id', 'id');
    }

}