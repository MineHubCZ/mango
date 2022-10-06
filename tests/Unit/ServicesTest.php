<?php

declare(strict_types=1);

use App\Services;
use Lemon\Contracts\Config\Config;

function get_services(): Services
{
    return new Services(
        mock(Config::class)
            ->expect(
                file: fn () => __DIR__.DIRECTORY_SEPARATOR.'services.php'
            )
    );
}

beforeEach(function () {
    file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'services.php', <<<'HTML'
        <?php
        
        return [
            'survival' => 1,
            'web' => 0,
            'skyblock' => 2,
        ];
    HTML);
});

afterEach(function () {
    unlink(__DIR__.DIRECTORY_SEPARATOR.'services.php');
});

it('returns all services', function () {
    $services = get_services();
    expect($services->all())
        ->toBe([
            'survival' => 1,
            'web' => 0,
            'skyblock' => 2,
        ])
    ;
});

it('changes service', function () {
    $services = get_services();
    $services->set('survival', 0);
    expect($services->all())
        ->toBe([
            'survival' => 0,
            'web' => 0,
            'skyblock' => 2,
        ])
    ;
});
