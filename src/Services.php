<?php

namespace App;

use Lemon\Contracts\Config\Config;

class Services
{
    private array $data;

    public readonly string $file;

    public function __construct(Config $config)
    {
        $this->file = $config->file('services.file', 'json');
        $content = file_get_contents($this->file);
        $this->data = json_decode($content);        
    }

    public function __destruct()
    {
        // We use pretty print to keep adding new services simpler
        file_put_contents($this->file, json_encode($this->data, JSON_PRETTY_PRINT)); 
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

    public function status(string $name): int
    {
        return $this->data[$name];
    }
}
