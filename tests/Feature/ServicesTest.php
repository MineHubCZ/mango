<?php

declare(strict_types=1);

use App\Contracts\Services;
use Lemon\Contracts\Config\Config;

it('returns all services', function () {
    $this->mock(Services::class)
        ->expect(all: fn () => ['web' => 1, 'survival' => 2])
    ;

    $this->request('api/services')
        ->assertBody(['web' => 1, 'survival' => 2])
    ;
});

it('won\'t let unauthorized user edit', function () {
    $this->mock(Config::class)
        ->expect(file: fn () => __DIR__.DIRECTORY_SEPARATOR.'tokens.mock')
    ;

    $this->mock(Services::class)
        ->expect(
            set: fn () => $this,
            has: fn () => false,
        )
    ;

    $this->request('api/services/web/edit', method: 'POST')
        ->assertBody(['code' => 401, 'error' => 'Invalid token'])
        ->assertStatus(401)
    ;
});

it('won\'t let unauthorized user with bad token edit', function () {
    $this->mock(Config::class)
        ->expect(file: fn () => __DIR__.DIRECTORY_SEPARATOR.'tokens.mock')
    ;

    $this->mock(Services::class)
        ->expect(
            set: fn () => $this,
            has: fn () => false,
        )
    ;

    $this->request('api/services/web/edit', method: 'POST', body: '{"token":"nevimneco","status":2}', headers: ['Content-Type' => 'application/json'])
        ->assertBody(['code' => 401, 'error' => 'Invalid token'])
        ->assertStatus(401)
    ;
});

it('edits service', function () {
    $this->mock(Config::class)
        ->expect(
            file: fn () => __DIR__.DIRECTORY_SEPARATOR.'tokens.mock',
            get : fn () => null
        )
    ;

    $services = $this->mock(Services::class)
        ->expect(
            set: function (string $name, int $status) {
                $this->data[$name] = $status;

                return $this;
            },
            has: fn ($name) => isset($this->data[$name]),
            all: fn () => $this->data
        )
    ;

    $services->data = ['web' => 1]; // forgive me

    $this->request('api/services/web/edit', method: 'POST', body: '{"token":"rizkoparek","status":2}', headers: ['Content-Type' => 'application/json'])
        ->assertOK()
    ;

    expect($services->all()['web'])
        ->toBe(2)
    ;
});

it('won\'t edit not-existing service', function () {
    $this->mock(Config::class)
        ->expect(
            file: fn () => __DIR__.DIRECTORY_SEPARATOR.'tokens.mock',
            get : fn () => null
        )
    ;

    $this->mock(Services::class)
        ->expect(
            has: fn () => false,
        )
    ;
    $this->request('api/services/web/edit', method: 'POST', body: '{"token":"rizkoparek","status":2}', headers: ['Content-Type' => 'application/json'])
        ->assertStatus(404)
    ;
});
