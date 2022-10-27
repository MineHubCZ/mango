<?php

declare(strict_types=1);

namespace App\Contracts;

interface WebhookManager
{
    public function send(string $service, int $status): static;

    public function terminate(): void;
}
