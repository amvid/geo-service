<?php

declare(strict_types=1);

namespace App\State\Action\Update;

interface UpdateStateActionInterface
{
    public function run(UpdateStateActionRequest $request): UpdateStateActionResponse;
}