<?php

declare(strict_types=1);

include __DIR__.'/vendor/autoload.php';

use App\Contracts\Services as ContractsServices;
use App\Services;
use App\WebhookManager;
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
$application->alias(ContractsServices::class, Services::class);

$application->get('templating.env')->macro('capitalize', 'ucfirst');
$application->get('templating.env')->macro('toStatusClass', function (int $status) {
    return match ($status) {
        0 => 'offline',
        1 => 'online',
        2 => 'maintenance',
        default => throw new Exception('Status '.$status.' doesnt have class')
    };
});

$application->add(WebhookManager::class);

return $application;
