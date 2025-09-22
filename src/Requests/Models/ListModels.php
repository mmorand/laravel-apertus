<?php

namespace Mmorand\Apertus\Requests\Models;

use JsonException;
use Mmorand\Apertus\Dto\Models\ModelListResponse;
use Mmorand\Apertus\Requests\BaseRequest;
use Saloon\Enums\Method;
use Saloon\Http\Response;

class ListModels extends BaseRequest
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/models';
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ModelListResponse
    {
        return ModelListResponse::from($response->json());
    }
}
