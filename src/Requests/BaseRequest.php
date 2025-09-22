<?php

namespace Mmorand\Apertus\Requests;

use Saloon\Http\Request;

abstract class BaseRequest extends Request
{
    abstract public function resolveEndpoint(): string;

    public function defaultHeaders(): array
    {
        return [
            ...parent::defaultHeaders(),
            'User-Agent' => config('apertus.user_agent'),
        ];
    }
}
