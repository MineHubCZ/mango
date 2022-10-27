<?php

declare(strict_types=1);

use App\Controllers\Api\Services;
use App\Middlewares\Auth;
use Lemon\Route;

Route::get('services', [Services::class, 'index']);

Route::collection(function() {
    Route::post('services/{service}/edit', [Services::class, 'edit']);
    Route::post('services/edit', [Services::class, 'editMultiple']);
})->middleware([Auth::class, 'onlyAuthenticated']);
