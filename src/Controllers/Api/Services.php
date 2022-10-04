<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Services as ServicesRepository;
use Lemon\Http\Request;
use Lemon\Http\Response;

class Services
{
    public function index(): array
    {
    }

    public function edit(string $service, ServicesRepository $services, Request $request): array|Response
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
    }
}
