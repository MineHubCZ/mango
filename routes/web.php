<?php

declare(strict_types=1);

use App\Controllers\Welcome;
use Lemon\Route;

Route::get('/', [Welcome::class, 'handle']);
