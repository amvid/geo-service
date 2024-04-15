<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Action\GetPhoneCodes;

use App\Country\Action\GetPhoneCodes\GetPhoneCodesAction;
use App\Country\Action\GetPhoneCodes\GetPhoneCodesActionRequest;
use App\Country\Controller\Response\PhoneCodeResponse;
use App\Country\Repository\CountryRepositoryInterface;
use App\Tests\Unit\Country\CountryDummy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetPhoneCodesActionTest extends TestCase
{
    private CountryRepositoryInterface&MockObject $countryRepository;
    private GetPhoneCodesActionRequest $request;

    private string $title = 'Norway';
    private string $phoneCode = '47';
    private int $limit = 10;
    private int $offset = 0;

    protected function setUp(): void
    {
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->request = new GetPhoneCodesActionRequest();

        $this->request->phoneCode = $this->phoneCode;
        $this->request->title = $this->title;
        $this->request->limit = $this->limit;
        $this->request->offset = $this->offset;
    }

    public function testShouldReturnCountryResponse(): void
    {
        $country = CountryDummy::get();

        $this->countryRepository
            ->expects($this->once())
            ->method('findPhoneCodes')
            ->with(
                $this->offset,
                $this->limit,
                $this->title,
                $this->phoneCode
            )
            ->willReturn([$country]);

        $expectedResponse = new PhoneCodeResponse($country);

        $action = new GetPhoneCodesAction($this->countryRepository);
        $actual = $action->run($this->request);

        $this->assertCount(1, $actual->response);
        $this->assertEquals($expectedResponse, $actual->response[0]);
    }
}
