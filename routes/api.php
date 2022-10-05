<?php

declare(strict_types=1);

use App\Controllers\Api\Services;
use App\Middlewares\Auth;
use Lemon\Route;

Route::get('services', [Services::class, 'index']);

Route::post('services/{service}/edit', [Services::class, 'edit'])
    ->middleware([Auth::class, 'onlyAuthenticated'])
;
