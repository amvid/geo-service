<?php

declare(strict_types=1);

namespace App\Tests\Unit\Currency\Action\Delete;

use App\Currency\Action\Delete\DeleteCurrencyAction;
use App\Currency\Action\Delete\DeleteCurrencyActionRequest;
use App\Currency\Entity\Currency;
use App\Currency\Repository\CurrencyRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCurrencyActionTest extends TestCase
{
    private CurrencyRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid7();
        $name = 'Euro';
        $code = 'EUR';
        $symbol = '€';

        $currency = new Currency($id);
        $currency
            ->setName($name)
            ->setCode($code)
            ->setSymbol($symbol)
            ->setCreatedAt();

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($currency);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($currency, true);

        $action = new DeleteCurrencyAction($this->repository);
        $req = new DeleteCurrencyActionRequest($id->toString());

        $action->run($req);
    }

    public function testShouldReturnResponseIfResourceNotFound(): void
    {
        $id = Uuid::uuid4();

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new DeleteCurrencyAction($this->repository);
        $req = new DeleteCurrencyActionRequest($id->toString());

        $action->run($req);
    }

}