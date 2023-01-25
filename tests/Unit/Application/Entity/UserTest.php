<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Entity;

use App\Application\Entity\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $password = 'password';
        $email = 'john@doe.com';
        $id = Uuid::uuid7();
        $role = User::USER;
        $user = new User($id);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setRoles([$role]);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($role, $user->getRoles()[0]);
    }
}
