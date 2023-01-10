<?php

declare(strict_types=1);

namespace App\Application\Helper;

use Generator;

interface CsvReaderInterface
{
    public function read(string $filepath, string $delimiter = ','): Generator;
}