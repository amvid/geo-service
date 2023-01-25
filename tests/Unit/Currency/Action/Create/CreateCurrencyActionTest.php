<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Create;

use App\Currency\Action\Create\CreateCurrencyAction;
use App\Currency\Action\Create\CreateCurrencyActionRequest;
use App\Currency\Action\Create\CreateCurrencyActionResponse;
use App\Currency\Entity\Currency;
use App\Currency\Exception\CurrencyAlreadyExistsException;
use App\Currency\Factory\CurrencyFactoryInterface;
use App\Currency\Repository\CurrencyRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateCurrencyActionTest extends TestCase
{
    private readonly CurrencyFactoryInterface $factory;
    private readonly CurrencyRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(CurrencyFactoryInterface::class)->getMock();
        $this->repository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnAValidResponseOnSuccess(): void
    {
        $id = Uuid::uuid4();
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $request = new CreateCurrencyActionRequest($name, $code, $symbol);
        $this->assertEquals($name, $request->name);
        $this->assertEquals($code, $request->code);
        $this->assertEquals($symbol, $request->symbol);

        $currency = new Currency($id);
        $currency->setName($name);
        $currency->setCode($code);
        $currency->setSymbol($symbol);
        $currency->setCreatedAt();

        $expectedResponse = new CreateCurrencyActionResponse($currency);

        $this->repository->expects($this->once())->method('findByCode')->with($code)->willReturn(null);
        $this->factory->expects($this->once())->method('setName')->with($name)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCode')->with($code)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setSymbol')->with($symbol)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->willReturn($currency);
        $this->repository->expects($this->once())->method('save')->with($currency, true);

        $action = new CreateCurrencyAction($this->repository, $this->factory);

        try {
            $actual = $action->run($request);
        } catch (CurrencyAlreadyExistsException $e) {
            $this->fail('Must not thrown an exception: ' . $e->getMessage());
        }

        $this->assertEquals($expectedResponse->currencyResponse->id, $actual->currencyResponse->id);
        $this->assertEquals($expectedResponse->currencyResponse->name, $actual->currencyResponse->name);
        $this->assertEquals($expectedResponse->currencyResponse->code, $actual->currencyResponse->code);
        $this->assertEquals($expectedResponse->currencyResponse->symbol, $actual->currencyResponse->symbol);
    }

    public function testShouldThrowAnErrorIfTitleHasBeenAlreadyTaken(): void
    {
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $this->repository
            ->expects($this->once())
            ->method('findByCode')
            ->with($code)
            ->willReturn(new Currency());

        $action = new CreateCurrencyAction($this->repository, $this->factory);
        $request = new CreateCurrencyActionRequest($name, $code, $symbol);

        $this->expectException(CurrencyAlreadyExistsException::class);
        $action->run($request);
    }
}
