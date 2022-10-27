<?php

namespace App\Contracts;

interface WebhookManager
{
    public function send(string $service, int $status): static;

    public function terminate(): void;
}
