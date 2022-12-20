<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Currency\Get;

use App\Action\Currency\Get\GetCurrenciesActionResponse;
use App\Entity\Currency;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetCurrenciesActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $nok = new Currency($id1);
        $eur = new Currency($id2);

        $actual = new GetCurrenciesActionResponse([$nok, $eur]);

        $this->assertCount(2, $actual->currencies);
        $this->assertEquals($nok, $actual->currencies[0]);
        $this->assertEquals($eur, $actual->currencies[1]);
    }
}