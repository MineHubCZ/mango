<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Services as ServicesRepository;
use Lemon\Http\Request;
use Lemon\Http\Response;

class Services
{
    public function index(ServicesRepository $services): array
    {
        return $services->all();
    }

    public function edit($service, ServicesRepository $services, Request $request): array|Response
    {
        $e = $request->validate([
            'status' => 'numeric|min:0|max:2',
        ]);

        if ($e) {
            return response([
                'code' => 400,
                'error' => 'Bad request data',
            ])->code(400);
        }

        $services->set($service, (int) $request->get('status'));
        return ['code' => 200];
    }
}
