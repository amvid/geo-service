<?php

declare(strict_types=1);

namespace App\State\Action\Get;

use App\State\Controller\Response\StateResponse;

class GetStatesActionResponse
{
    /**
     * @var array<StateResponse> $response
     */
    public array $response = [];

    public function __construct(array $states)
    {
        foreach ($states as $state) {
            $this->response[] = new StateResponse($state);
        }
    }
}
