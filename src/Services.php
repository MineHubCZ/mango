<?php

namespace App;

use Lemon\Contracts\Config\Config;

class Services
{
    private string $content;

    private array $data;

    public function __construct(Config $config)
    {
        $this->content = file_get_contents($config->file('services.file', 'json'));
        $this->data = json_decode($this->content);        
    }

    public function all(): array
    {
        return $this->data;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function set(string $name, int $status): static
    {
        $this->data[$name] = $status;
        return $this;
    }

    public function status(string $name): int
    {
        return $this->data[$name];
    }
}
