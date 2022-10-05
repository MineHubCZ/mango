<?php

use App\Services;

it('returns all services', function() {
    $this->application->add(
        Services::class,
        mock(Services::class)
            ->expect(all: fn() => ['web' => 1, 'survival' => 2])
    );    
    $this->request('api/services')
         ->assertBody(['web' => 1, 'survival' => 2])
    ;
});

it('won\'t let unauthorized user to edit', function() {
    $this->application->add(
        Config::class,
        mock(Config::class)
            ->expect(file: fn() => __DIR__.DIRECTORY_SEPARATOR.'tokens.mock.php')
    );
    $this->request('api/services/web/edit', method: 'POST')
         ->assertBody(['code' => 401, 'error' => "Invalid token"])
         ->assertCode(401)
    ;   
});

it('edits service', function() {
    
});
