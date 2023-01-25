<?php

declare(strict_types=1);

namespace App\Application\Command\Import;

use JsonException;

class ImportHelper
{
    /**
     * @throws JsonException
     */
    public static function getDataFromJsonFile(string $file): array
    {
        return json_decode(
            file_get_contents($file),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
