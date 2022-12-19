<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Timezone;

interface TimezoneFactoryInterface
{
    public function setTitle(string $title): self;

    public function setCode(string $code): self;

    public function setUtc(string $utc): self;

    public function setTimezone(Timezone $timezone): self;

    public function create(): Timezone;
}