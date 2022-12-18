<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Timezone;
use Symfony\Component\Uid\Uuid;

interface TimezoneRepositoryInterface
{
    public function save(Timezone $timezone, bool $flush = false): void;
    public function remove(Timezone $timezone, bool $flush = false): void;
    public function findById(Uuid $id): ?Timezone;
    public function findByTitle(string $title): ?Timezone;
    public function findByCode(string $code): ?Timezone;
}