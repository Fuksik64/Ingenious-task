<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Invoice\Infrastructure\Cast\UuidCast;

final class InvoiceProductLine extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    public $keyType = 'string';

    protected $casts
        = [
            'id' => UuidCast::class,
            'invoice_id' => UuidCast::class
        ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

}