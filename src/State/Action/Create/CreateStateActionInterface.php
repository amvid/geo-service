<?php

declare(strict_types=1);

namespace App\State\Action\Create;

interface CreateStateActionInterface
{
    public function run(CreateStateActionRequest $request): CreateStateActionResponse;
}
