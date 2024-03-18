<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality;

use App\Nationality\Entity\Nationality;
use Ramsey\Uuid\Uuid;

class NationalityDummy
{
    public const ID = '051da3fc-b555-41f7-8cd5-dc0bf1ff5566';
    public const TITLE = 'American';

    public static function get(): Nationality
    {
        $nationalityId = Uuid::fromString(self::ID);
        $nationality = new Nationality($nationalityId);
        $nationality->setTitle(self::TITLE)->setCreatedAt();
        return $nationality;
    }
}
