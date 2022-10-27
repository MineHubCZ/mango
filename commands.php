<?php

declare(strict_types=1);

use App\ArrayExporter;
use Lemon\Contracts\Config\Config;
use Lemon\Terminal;

Terminal::command('services:build', function (Config $config) {
    $file = $config->file('services.file', 'php');
    file_put_contents($file, ArrayExporter::export([]));
}, 'builds services file');

Terminal::command('repl', function() {
    Terminal::out('<div class="text-yellow">Repl started</div>');
    system('psysh init.php > `tty`');
}, 'starts repl (requires psysh on your machine)');
