<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Create;

use App\Nationality\Action\Create\CreateNationalityAction;
use App\Nationality\Action\Create\CreateNationalityActionRequest;
use App\Nationality\Action\Create\CreateNationalityActionResponse;
use App\Nationality\Entity\Nationality;
use App\Nationality\Exception\NationalityAlreadyExistsException;
use App\Nationality\Factory\NationalityFactoryInterface;
use App\Nationality\Repository\NationalityRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateNationalityActionTest extends TestCase
{
    private readonly NationalityFactoryInterface&MockObject $factory;
    private readonly NationalityRepositoryInterface&MockObject $repository;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(NationalityFactoryInterface::class)->getMock();
        $this->repository = $this->getMockBuilder(NationalityRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnAValidResponseOnSuccess(): void
    {
        $id = Uuid::uuid7();
        $title = 'American';

        $request = new CreateNationalityActionRequest();
        $request->title = $title;
        $this->assertEquals($title, $request->title);

        $nationality = new Nationality($id);
        $nationality->setTitle($title);
        $nationality->setCreatedAt();

        $expectedResponse = new CreateNationalityActionResponse($nationality);

        $this->repository->expects($this->once())->method('findByTitle')->with($title)->willReturn(null);
        $this->factory->expects($this->once())->method('setTitle')->with($title)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->willReturn($nationality);
        $this->repository->expects($this->once())->method('save')->with($nationality, true);

        $action = new CreateNationalityAction($this->repository, $this->factory);

        try {
            $actual = $action->run($request);
        } catch (NationalityAlreadyExistsException $e) {
            $this->fail('Must not thrown an exception: ' . $e->getMessage());
        }

        $this->assertEquals($expectedResponse->nationalityResponse->id, $actual->nationalityResponse->id);
        $this->assertEquals($expectedResponse->nationalityResponse->title, $actual->nationalityResponse->title);
    }

    public function testShouldThrowAnErrorIfTitleHasBeenAlreadyTaken(): void
    {
        $title = 'American';
        $this->repository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($title)
            ->willReturn(new Nationality());

        $action = new CreateNationalityAction($this->repository, $this->factory);
        $request = new CreateNationalityActionRequest();
        $request->title = $title;

        $this->expectException(NationalityAlreadyExistsException::class);
        $action->run($request);
    }
}
