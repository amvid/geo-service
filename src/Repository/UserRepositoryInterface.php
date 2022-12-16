<?php

declare(strict_types=1);

namespace App\Repository;
use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user, bool $flush = false): void;
    public function remove(User $user, bool $flush = false): void;
    public function findByEmail(string $email): ?User;
}