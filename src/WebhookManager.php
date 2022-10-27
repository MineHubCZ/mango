<?php

declare(strict_types=1);

namespace App;

use App\Contracts\WebhookManager as ContractsWebhookManager;
use GuzzleHttp\Client;
use Lemon\Contracts\Config\Config;

class WebhookManager implements ContractsWebhookManager
{
    public const Colors = [
        0xA63C30,
        0x66AC64,
        0xDE9C2B,
    ];

    public const Statuses = [
        'Offline',
        'Online',
        'Údržba',
    ];
    private array $embeds = [];

    public function __construct(
        private Config $config
    ) {
    }

    public function send(string $service, int $status): static
    {
        $this->embeds[] = [$service, $status];

        return $this;
    }

    public function buildSlackJson(): string
    {
        return json_encode([
            'attachments' => array_map(fn ($embed) => [
                'title' => ucfirst($embed[0]),
                'color' => static::Colors[$embed[1]],
                'fields' => [
                    [
                        'title' => 'Stav',
                        'value' => self::Statuses[$embed[1]],
                    ],
                ],
            ], $this->embeds),
        ]);
    }

    public function buildDiscordJson(): string
    {
        return json_encode([
            'embeds' => array_map(fn ($embed) => [
                'title' => ucfirst($embed[0]),
                'color' => static::Colors[$embed[1]],
                'fields' => [
                    [
                        'name' => 'Stav',
                        'value' => self::Statuses[$embed[1]],
                    ],
                ],
            ], $this->embeds),
        ]);
    }

    public function terminate(): void
    {
        $client = new Client();

        if (!$this->embeds) {
            return;
        }

        if (($url = $this->config->get('webhooks.discord')) != '') {
            $client->post($url, [
                'body' => $this->buildDiscordJson(),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        }

        if (($url = $this->config->get('webhooks.slack')) != '') {
            $client->post($url, [
                'body' => $this->buildSlackJson(),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
    }
}
