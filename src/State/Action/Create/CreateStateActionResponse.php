<?php

declare(strict_types=1);

namespace App\State\Action\Create;

use App\State\Controller\Response\StateResponse;
use App\State\Entity\State;

class CreateStateActionResponse
{
    public StateResponse $state;

    public function __construct(State $state)
    {
        $this->state = new StateResponse($state);
    }
}