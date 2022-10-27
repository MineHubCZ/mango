<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Contracts\Services as ServicesRepository;
use Lemon\Http\Request;
use Lemon\Http\Response;
use Lemon\Terminal;

class Services
{
    public function index(ServicesRepository $services): array
    {
        return $services->all();
    }

    public function edit($service, ServicesRepository $services, Request $request): array|Response
    {
        $e = $request->validate([
            'status' => 'numeric|max:1',
        ]);

        if (!$e || !in_array($request->get('status'), [0, 1, 2])) {
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

        $services->set($service, $request->get('status'));

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
            if (!$services->has($service)) {
                $services->dontSave();
                return response([
                    'code' => 400,
                    'error' => 'Service '.$service.' does not exist',
                ])->code(400);
            }

            if (!in_array($status, [0, 1, 2])) {
                $services->dontSave();
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
