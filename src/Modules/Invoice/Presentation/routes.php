<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Presentation\Http\InvoiceController;
use Modules\Invoice\Presentation\Http\InvoiceSendController;


Route::get('invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::post('invoice', [InvoiceController::class, 'store'])->name('invoice.store');


Route::post('invoice/{invoice}/send', [InvoiceSendController::class, 'store'])->name('invoice.send.store');