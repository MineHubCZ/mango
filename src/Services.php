<?php

declare(strict_types=1);

namespace App;

use App\Contracts\Services as ContractsServices;
use Lemon\Contracts\Config\Config;

class Services implements ContractsServices
{
    public readonly string $file;
    private array $data;

    public function __construct(Config $config)
    {
        $this->file = $config->file('services.file', 'php');
        $this->data = require $this->file;
    }

    public function __destruct()
    {
        file_put_contents($this->file, ArrayExporter::export($this->data));
    }

    public function all(): array
    {
        return $this->data;
    }

    public function set(string $name, int $status): static
    {
        $this->data[$name] = $status;

        return $this;
    }

    public function has(string $name): bool
    {
        return isset($this->data[$name]);
    }
}
