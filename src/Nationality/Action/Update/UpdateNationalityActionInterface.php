<?php

declare(strict_types=1);

namespace App\Nationality\Action\Update;

interface UpdateNationalityActionInterface
{
    public function run(UpdateNationalityActionRequest $request): UpdateNationalityActionResponse;
}
