<?php

namespace App\Middlewares;

use Lemon\Http\Request;
use Lemon\Http\Response;
use Lemon\Kernel\Application;

class Auth
{
    public function onlyAuthenticated(Application $app, Request $request): ?Response
    {
        $tokens = explode("\n", file_get_contents($app->file('', 'tokens.example')));

        if (!in_array($request->get('token'), $tokens)) {
            return response([
                'code' => '401',
                'error' => 'Invalid token', 
            ])->code(401);
        }

        return null;
    }
}
