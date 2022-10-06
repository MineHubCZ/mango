<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\Services;
use Lemon\Templating\Template;

class Welcome
{
    public function handle(Services $services): Template
    {
        return template('welcome', services: $services->all());
    }
}
