<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Get;

use App\Country\Entity\Country;
use App\Country\Repository\CountryRepositoryInterface;
use App\Currency\Entity\Currency;
use App\Region\Entity\Region;
use App\State\Action\Get\GetStatesAction;
use App\State\Action\Get\GetStatesActionRequest;
use App\State\Entity\State;
use App\State\Repository\StateRepositoryInterface;
use App\SubRegion\Entity\SubRegion;
use App\Tests\Unit\Country\CountryDummy;
use App\Timezone\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetStatesActionTest extends TestCase
{
    private CountryRepositoryInterface $countryRepository;
    private StateRepositoryInterface $stateRepository;

    private GetStatesActionRequest $request;

    private int $offset;
    private int $limit;
    private string $title;
    private string $code;
    private string $type;
    private string $countryIso2;
    private UuidInterface $stateId;

    protected function setUp(): void
    {
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();
        $this->stateRepository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();

        $this->stateId = Uuid::uuid4();
        $this->title = 'New Jersey';
        $this->code = 'NJ';
        $this->type = 'state';
        $this->countryIso2 = 'US';
        $this->offset = 0;
        $this->limit = 10;

        $this->request = new GetStatesActionRequest();
        $this->request->countryIso2 = $this->countryIso2;
        $this->request->title = $this->title;
        $this->request->type = $this->type;
        $this->request->code = $this->code;
        $this->request->offset = $this->offset;
        $this->request->limit = $this->limit;
        $this->request->id = $this->stateId;
    }

    public function testShouldReturnAnEmptyResponseIfCountryNotFound(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new GetStatesAction($this->countryRepository, $this->stateRepository);
        $actual = $action->run($this->request);

        $this->assertEquals([], $actual->response);
    }

    public function testShouldReturnAValidResponseOfState(): void
    {
        $country = CountryDummy::get();

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $state = new State($this->stateId);
        $state
            ->setCountry($country)
            ->setCode($this->code)
            ->setTitle($this->title)
            ->setType($this->type)
            ->setLatitude(10)
            ->setLongitude(50)
            ->setAltitude(10)
            ->setCreatedAt();

        $this->stateRepository
            ->expects($this->once())
            ->method('list')
            ->with(
                $this->offset,
                $this->limit,
                $this->stateId,
                $this->code,
                $this->title,
                $this->type,
                $country->getId(),
            )
            ->willReturn([$state]);

        $action = new GetStatesAction($this->countryRepository, $this->stateRepository);
        $actual = $action->run($this->request);

        $this->assertEquals($state->getId(), $actual->response[0]->id);
    }
}
