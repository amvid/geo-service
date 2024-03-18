<?php

declare(strict_types=1);

namespace App\Nationality\Action\Create;

interface CreateNationalityActionInterface
{
    public function run(CreateNationalityActionRequest $request): CreateNationalityActionResponse;
}
