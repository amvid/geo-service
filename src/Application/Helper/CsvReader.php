<?php

declare(strict_types=1);

namespace App\Application\Helper;

use Generator;
use RuntimeException;

class CsvReader implements CsvReaderInterface
{
    public function read(string $filepath, string $delimiter = ','): Generator
    {
        $header = [];
        $row = 0;
        $handle = fopen($filepath, 'rb');

        if (!$handle) {
            throw new RuntimeException("Could not open the file: $filepath");
        }

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (0 === $row) {
                $header = $data;
            } else {
                yield array_combine($header, $data);
            }

            $row++;
        }
        fclose($handle);
    }
}