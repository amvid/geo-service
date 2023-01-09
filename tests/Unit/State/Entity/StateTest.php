<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Entity;

use App\Country\Entity\Country;
use App\State\Entity\State;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class StateTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $countryId = Uuid::uuid4();
        $country = new Country($countryId);

        $id = Uuid::uuid4();
        $title = 'New Jersey';
        $code = 'NJ';

        $actual = new State($id);
        $actual->setCountry($country)->setTitle($title)->setCode($code);

        $this->assertEquals($id, $actual->getId());
        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($code, $actual->getCode());
        $this->assertEquals($countryId, $actual->getCountry()->getId());
    }
}