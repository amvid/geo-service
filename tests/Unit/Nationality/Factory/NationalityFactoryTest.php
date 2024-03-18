<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Factory;

use App\Nationality\Factory\NationalityFactory;
use App\Nationality\Factory\NationalityFactoryInterface;
use PHPUnit\Framework\TestCase;

class NationalityFactoryTest extends TestCase
{
    private NationalityFactoryInterface $nationalityFactory;

    protected function setUp(): void
    {
        $this->nationalityFactory = new NationalityFactory();
    }

    public function testShouldReturnANewNationality(): void
    {
        $title = 'American';

        $actual = $this->nationalityFactory
            ->setTitle($title)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
    }
}
