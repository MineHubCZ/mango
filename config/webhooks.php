<?php

declare(strict_types=1);

use Lemon\Env;

return [
    'discord' => Env::get('DISCORD_WEBHOOK', ''),
    'slack' => Env::get('SLACK_WEBHOOK', ''),
];
