<?php

declare(strict_types=1);

namespace App;

use App\Contracts\Services as ContractsServices;
use App\Contracts\WebhookManager;
use Lemon\Contracts\Config\Config;
use Lemon\Terminal;

class Services implements ContractsServices
{
    public readonly string $file;
    private array $data;
    private bool $dont_save = false;

    public function __construct(
        Config $config,
        private WebhookManager $webhookManager
    ) {
        $this->file = $config->file('services.file', 'php');
        $this->data = require $this->file;
    }

    public function __destruct()
    {
        if ($this->dont_save) {
            return;
        }

        file_put_contents($this->file, ArrayExporter::export($this->data));
        $this->webhookManager->terminate();
    }

    public function all(): array
    {
        return $this->data;
    }

    public function set(string $name, int $status): static
    {
        if ($status == $this->data[$name]) {
            return $this;
        }

        $this->webhookManager->send($name, $status);

        $this->data[$name] = $status;

        return $this;
    }

    public function dontSave(): static
    {
        $this->dont_save = true;
        return $this;
    }

    public function has(string $name): bool
    {
        return isset($this->data[$name]);
    }
}
