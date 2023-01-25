<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Get;

use App\Currency\Action\Get\GetCurrenciesAction;
use App\Currency\Action\Get\GetCurrenciesActionRequest;
use App\Currency\Entity\Currency;
use App\Currency\Repository\CurrencyRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetCurrenciesActionTest extends TestCase
{
    private CurrencyRepositoryInterface $repository;
    private Currency $nok;
    private Currency $eur;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();

        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $this->nok = new Currency($id1);
        $this->nok->setName('Norwegian Krone');
        $this->nok->setCode('NOK');
        $this->nok->setSymbol('kr');
        $this->nok->setCreatedAt();

        $this->eur = new Currency($id2);
        $this->eur->setName('Euro');
        $this->eur->setCode('EUR');
        $this->eur->setSymbol('€');
        $this->eur->setCreatedAt();
    }

    public function testShouldReturnResponseArrayOfRegions(): void
    {
        $limit = 10;
        $offset = 0;

        $currencies = [$this->nok, $this->eur];

        $this->repository
            ->expects($this->once())
            ->method('list')
            ->with($offset, $limit)
            ->willReturn($currencies);

        $req = new GetCurrenciesActionRequest();
        $req->limit = $limit;
        $req->offset = $offset;

        $action = new GetCurrenciesAction($this->repository);
        $actual = $action->run($req);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($this->nok->getId(), $actual->response[0]->id);
        $this->assertEquals($this->eur->getId(), $actual->response[1]->id);
    }
}
