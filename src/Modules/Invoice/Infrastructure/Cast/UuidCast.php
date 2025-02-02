<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UuidCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_string($value)) {
            return Uuid::fromString($value);
        }

        return $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {

        if($value instanceof UuidInterface) {
            return $value->toString();
        }

        return $value;
    }
}