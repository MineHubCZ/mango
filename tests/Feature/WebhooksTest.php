<?php

use App\WebhookManager;
use Lemon\Contracts\Config\Config;

it('generates json', function() {
    $this->mock(Config::class);
    /** @var WebhookManager $manager */
    $manager = $this->application->get(WebhookManager::class);
    $manager->send('web', 1)
            ->send('identita', 0)
            ->send('skyblock', 2)
        ;
    expect($manager->buildJson())
        ->json()
        ->toBe([
            'attachments' => [
                [
                    'title' => 'Web',
                    'color' => 0x66AC64,
                    'fields' => [
                        [
                            'title' => 'Stav',
                            'value' => 'Online',
                        ],
                    ],
                ],
                [
                    'title' => 'Identita',
                    'color' => 0xA63C30,
                    'fields' => [
                        [
                            'title' => 'Stav',
                            'value' => 'Offline',
                        ],
                    ],
                ],
                [
                    'title' => 'Skyblock',
                    'color' => 0xDE9C2B,
                    'fields' => [
                        [
                            'title' => 'Stav',
                            'value' => 'Údržba',
                        ],
                    ],
                ],
            ]
        ]);
});
