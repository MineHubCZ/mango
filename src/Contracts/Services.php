<?php

namespace App\Contracts;

interface Services
{
    public function all(): array;

    public function set(string $name, int $status): static;

    public function has(string $name): bool;
}
