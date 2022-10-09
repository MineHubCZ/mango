<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Contracts\Services as ServicesRepository;
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
            'status' => 'numeric|min:-1|max:3',
        ]);

        if (!$e) {
            return response([
                'code' => 400,
                'error' => 'Bad request data',
            ])->code(400);
        }

        if (!$services->has($service)) {
            return response([
                'code' => 404,
                'error' => 'Service not found',
            ])->code(404);
        }

        $services->set($service, (int) $request->get('status'));

        return ['code' => 200];
    }

    public function editMultiple(ServicesRepository $services, Request $request)
    {
        if (!$request->is('application/json')) {
            return response([
                'code' => 400,
                'error' => 'Expected json',
            ])->code(400);
        }

        foreach ($request->get('services') as $service => $status) {
            if (!is_string($service)) {
                return response([
                    'code' => 400,
                    'error' => 'Service name '.$service.' is not valid',
                ])->code(400);
            }

            if (!in_array($status, [0, 1, 2])) {
                return response([
                    'code' => 400,
                    'error' => 'Status '.$status.' is not valid',
                ])->code(400);
            }

            $services->set($service, $status);
        }

        return ['code' => 200];
    }
}
