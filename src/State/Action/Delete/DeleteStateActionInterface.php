<?php

declare(strict_types=1);

namespace App\State\Action\Delete;

interface DeleteStateActionInterface
{
    public function run(DeleteStateActionRequest $request): DeleteStateActionResponse;
}
