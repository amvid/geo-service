<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Factory;

use App\Application\Entity\User;
use App\Application\Factory\UserFactory;
use App\Application\Factory\UserFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactoryTest extends TestCase
{
    private UserPasswordHasherInterface&MockObject $hasher;
    private UserFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->hasher = $this->getMockBuilder(UserPasswordHasherInterface::class)->getMock();
        $this->factory = new UserFactory($this->hasher);
    }

    public function testShouldReturnANewUser(): void
    {
        $email = 'john@doe.com';
        $password = 'qwerty';
        $hashedPassword = '1234';
        $role = User::USER;

        $this->hasher
            ->expects($this->once())
            ->method('hashPassword')
            ->willReturn($hashedPassword);

        $actual = $this->factory
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles([$role])
            ->create();

        $this->assertEquals($email, $actual->getEmail());
        $this->assertEquals($hashedPassword, $actual->getPassword());
        $this->assertEquals($role, $actual->getRoles()[0]);
    }
}
