<?php

declare(strict_types=1);

namespace App\Timezone\Factory;

use App\Timezone\Entity\Timezone;

interface TimezoneFactoryInterface
{
    public function setTitle(string $title): self;

    public function setCode(string $code): self;

    public function setUtc(string $utc): self;

    public function setTimezone(Timezone $timezone): self;

    public function create(): Timezone;
}