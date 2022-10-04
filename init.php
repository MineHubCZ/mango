<?php

declare(strict_types=1);

include __DIR__.'/vendor/autoload.php';

use App\Services;
use Lemon\Http\Middlewares\Cors;
use Lemon\Kernel\Application;
use Lemon\Protection\Middlwares\Csrf;

$application = new Application(__DIR__);

// --- Loading default Lemon services ---
$application->loadServices();

// --- Loading Zests for services ---
$application->loadZests();

// --- Loading Error/Exception handlers ---
$application->loadHandler();

$application->get('config')->load();

/** @var \Lemon\Routing\Router $router */
$router = $application->get('routing');

$router->file('routes.web')
    ->middleware(Csrf::class)
;

$router->file('routes.api')
    ->prefix('api')
    ->middleware(Cors::class)
;

$application->add(Services::class);

return $application;
