<?php

declare(strict_types=1);

use App\ArrayExporter;

it('exports array', function () {
    expect(ArrayExporter::export(['foo' => 1, 'bar' => 2]))
        ->toBe(<<<'HTML'
        <?php
        
        return [
            'foo' => 1,
            'bar' => 2,
        ];
        HTML)
    ;
});
