<?php

declare(strict_types=1);

namespace Modules\Invoice\Infrastructure\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Invoice\Application\EventListener\InvoiceDeliveredListener;
use Modules\Invoice\Domain\Repository\InvoiceProductLineRepositoryInterface;
use Modules\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use Modules\Invoice\Infrastructure\Mapper\EloquentInvoiceToEntityMapper;
use Modules\Invoice\Infrastructure\Repository\EloquentInvoiceProductLineRepository;
use Modules\Invoice\Infrastructure\Repository\EloquentInvoiceRepository;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;

final class InvoiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoiceRepositoryInterface::class, EloquentInvoiceRepository::class);

        $this->app->singleton(EloquentInvoiceRepository::class, static fn($app) => new EloquentInvoiceRepository(
            $app->make(EloquentInvoiceToEntityMapper::class)
        ));

        $this->app->scoped(InvoiceProductLineRepositoryInterface::class, EloquentInvoiceProductLineRepository::class);
        $this->app->singleton(InvoiceProductLineRepositoryInterface::class, static fn($app) => new EloquentInvoiceProductLineRepository);

        Event::listen([ResourceDeliveredEvent::class], InvoiceDeliveredListener::class);
    }
}
