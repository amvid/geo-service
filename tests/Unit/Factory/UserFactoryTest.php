<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Factory\UserFactoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactoryTest extends TestCase
{
    private UserPasswordHasherInterface $hasher;
    private UserFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->hasher = $this->getMockBuilder(UserPasswordHasherInterface::class)->getMock();
        $this->factory = new UserFactory($this->hasher);
    }

    public function testShouldReturnAUser(): void
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

        self::assertEquals($email, $actual->getEmail());
        self::assertEquals($hashedPassword, $actual->getPassword());
        self::assertEquals($role, $actual->getRoles()[0]);
    }
}