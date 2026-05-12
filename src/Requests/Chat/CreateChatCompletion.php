<?php

namespace Mmorand\Apertus\Requests\Chat;

use JsonException;
use Mmorand\Apertus\Dto\Chat\ChatCompletionRequest;
use Mmorand\Apertus\Dto\Chat\ChatCompletionResponse;
use Mmorand\Apertus\Requests\BaseRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateChatCompletion extends BaseRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected ChatCompletionRequest $chatCompletionRequest) {}

    public function resolveEndpoint(): string
    {
        return '/v1/chat/completions';
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return array_filter(
            $this->chatCompletionRequest->toArray(),
            static fn ($v) => $v !== null
        );
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): ChatCompletionResponse
    {
        return ChatCompletionResponse::from($response->json());
    }
}
