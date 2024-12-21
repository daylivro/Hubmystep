<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FaqCatalogController;

Route::controller(FaqCatalogController::class)
    ->name('v1.faq')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('{faqCatalog}', 'show')->name('show');
    });
