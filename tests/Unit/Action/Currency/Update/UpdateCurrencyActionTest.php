<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Currency\Update;

use App\Action\Currency\Update\UpdateCurrencyAction;
use App\Action\Currency\Update\UpdateCurrencyActionRequest;
use App\Entity\Currency;
use App\Exception\CurrencyNotFoundException;
use App\Repository\CurrencyRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateCurrencyActionTest extends TestCase
{
    private CurrencyRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();
    }

    public function testShouldUpdateTimezoneAndReturnResponse(): void
    {
        $id = Uuid::uuid4();
        $name = 'Eur0';
        $code = '3UR';
        $symbol = 'E';

        $updateName = 'Euro';
        $updateCode = 'EUR';
        $updateSymbol = '€';

        $currency = new Currency($id);
        $currency
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol)
            ->setCreatedAt();

        $req = new UpdateCurrencyActionRequest();
        $req
            ->setName($updateName)
            ->setSymbol($updateSymbol)
            ->setCode($updateCode)
            ->setId($id->toString());

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($currency);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($currency);

        $action = new UpdateCurrencyAction($this->repository);

        try {
            $actual = $action->run($req);
        } catch (CurrencyNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateName, $actual->currencyResponse->name);
        $this->assertEquals($updateCode, $actual->currencyResponse->code);
        $this->assertEquals($updateSymbol, $actual->currencyResponse->symbol);
        $this->assertEquals($id, $actual->currencyResponse->id);
    }

    public function testShouldThrowNotFoundExceptionIfRegionNotFound(): void
    {
        $id = Uuid::uuid4();
        $req = new UpdateCurrencyActionRequest();
        $req->setId($id->toString());

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new UpdateCurrencyAction($this->repository);

        $this->expectException(CurrencyNotFoundException::class);
        $action->run($req);
    }
}