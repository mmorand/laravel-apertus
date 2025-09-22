<?php

namespace Mmorand\Apertus\Resources;

use Mmorand\Apertus\Dto\Chat\ChatCompletionRequest;
use Mmorand\Apertus\Enums\Model;
use Mmorand\Apertus\Requests\Chat\CreateChatCompletion;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Chat extends BaseResource
{
    /**
     * @param  array<int, string>|null  $logitBias
     * @param  array<int, array{role: string, content: string}>  $messages
     * @param  array<int, array{type: string, function: object}>|null  $tools
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function create(
        Model $model,
        array $messages,
        float $temperature = 0.7,
        int $topP = 1,
        ?int $n = null,
        bool $stream = false,
        ?string $stop = null,
        int $maxTokens = 2000,
        int|float|null $presencePenalty = null,
        int|float|null $frequencyPenalty = null,
        ?array $logitBias = null,
        ?string $user = null,
        ?array $tools = null,
        ?string $toolChoice = null,
    ): Response {
        return $this->connector->send(new CreateChatCompletion(
            new ChatCompletionRequest(
                model: $model->value,
                messages: $messages,
                temperature: $temperature,
                topP: $topP,
                n: $n,
                stream: $stream,
                stop: $stop,
                maxTokens: $maxTokens,
                presencePenalty: $presencePenalty,
                frequencyPenalty: $frequencyPenalty,
                logitBias: $logitBias,
                user: $user,
                tools: $tools,
                toolChoice: $toolChoice,
            )
        ));
    }
}
