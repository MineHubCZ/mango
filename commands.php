<?php

declare(strict_types=1);

use App\ArrayExporter;
use Lemon\Contracts\Config\Config;
use Lemon\Terminal;

Terminal::command('services:build', function (Config $config) {
    $file = $config->file('services.file', 'php');
    file_put_contents($file, ArrayExporter::export([]));
});
