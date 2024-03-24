<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Update;

use App\Nationality\Action\Update\UpdateNationalityActionRequest;
use PHPUnit\Framework\TestCase;

class UpdateNationalityActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $title = 'American';

        $actual = new UpdateNationalityActionRequest();
        $actual->setTitle($title);

        $this->assertEquals($title, $actual->title);
    }
}
