<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\Services;
use Lemon\Templating\Template;

class Welcome
{
    public function handle(Services $services): Template
    {
        return template('welcome', services: ['web' => 1, 'parek' => 2, 'rizek' => 0, 'rohlik' => 1]);
    }
}
