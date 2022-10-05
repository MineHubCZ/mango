<?php

declare(strict_types=1);

namespace App\Middlewares;

use Lemon\Contracts\Config\Config;
use Lemon\Http\Request;
use Lemon\Http\Response;

class Auth
{
    public function onlyAuthenticated(Config $config, Request $request): ?Response
    {
        $tokens = array_slice(
            explode("\n", file_get_contents($config->file('tokens.file'))),
            0,
            -1
        );

        if (!in_array($request->get('token'), $tokens)) {
            return response([
                'code' => 401,
                'error' => 'Invalid token',
            ])->code(401);
        }

        return null;
    }
}
