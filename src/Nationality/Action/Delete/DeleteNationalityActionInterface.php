<?php

declare(strict_types=1);

namespace App\Nationality\Action\Delete;

interface DeleteNationalityActionInterface
{
    public function run(DeleteNationalityActionRequest $request): DeleteNationalityActionResponse;
}
