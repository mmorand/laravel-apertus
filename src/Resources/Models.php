<?php

namespace Mmorand\Apertus\Resources;

use Mmorand\Apertus\Requests\Models\ListModels;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Models extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function list(): Response
    {
        return $this->connector->send(new ListModels);
    }
}
