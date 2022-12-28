<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Get;

use App\Currency\Action\Get\GetCurrenciesActionResponse;
use App\Currency\Entity\Currency;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetCurrenciesActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $nok = new Currency($id1);
        $nok->setName('Norwegian Krone');
        $nok->setCode('NOK');
        $nok->setSymbol('kr');
        $nok->setCreatedAt();

        $eur = new Currency($id2);
        $eur->setName('Euro');
        $eur->setCode('EUR');
        $eur->setSymbol('E');
        $eur->setCreatedAt();

        $actual = new GetCurrenciesActionResponse([$nok, $eur]);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($nok->getId(), $actual->response[0]->id);
        $this->assertEquals($eur->getId(), $actual->response[1]->id);
    }
}