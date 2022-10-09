<?php

namespace App;

use GuzzleHttp\Client;
use Lemon\Contracts\Config\Config;

class WebhookManager
{
    private array $embeds = [];

    public const Colors = [
        0xA63C30,
        0x66AC64,
        0xDE9C2B,
    ];

    public const Statuses = [
        'Offline',
        'Online',
        'Údržba'
    ];

    public function __construct(
        private Config $config 
    ) {
        
    }

    public function send(string $service, int $status): static
    {
        $this->embeds[] = [$service, $status];
        return $this;
    }

    public function buildJson(): string
    {
        return json_encode([
            'attachments' => array_map(fn($embed) => [
                    'title' => ucfirst($embed[0]),
                    'color' => static::Colors[$embed[1]],
                    'fields' => [
                        [
                            'title' => 'Stav',
                            'value' => self::Statuses[$embed[1]],
                        ]
                    ]
                ], $this->embeds)
        ]);
    }

    public function terminate()
    {
        $client = new Client();

        if (($url = $this->config->get('webhooks.discord')) != null) {
            $client->post($url.'/slack', [
                'body' => $this->buildJson()
            ]);
        }

        if (($url = $this->config->get('webhooks.slack')) != null) {
            $client->post($url, [
                'body' => $this->buildJson()
            ]);
        }

    }
}
