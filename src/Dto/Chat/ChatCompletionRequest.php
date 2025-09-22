<?php

namespace Mmorand\Apertus\Dto\Chat;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ChatCompletionRequest extends SpatieData
{
    /**
     * @param  array<int, string>|null  $logitBias
     * @param  array<int, array{role: string, content: string}>  $messages
     * @param  array<int, array{type: string, function: object}>|null  $tools
     */
    public function __construct(
        public string $model,
        public array $messages,
        public int|float|null $temperature = null,
        #[MapName('top_p')]
        public int|float|null $topP = null,
        public ?int $n = null,
        public ?bool $stream = null,
        public ?string $stop = null,
        #[MapName('max_tokens')]
        public ?int $maxTokens = null,
        #[MapName('presence_penalty')]
        public int|float|null $presencePenalty = null,
        #[MapName('frequency_penalty')]
        public int|float|null $frequencyPenalty = null,
        #[MapName('logit_bias')]
        public ?array $logitBias = null,
        public ?string $user = null,
        public ?array $tools = null,
        #[MapName('tool_choice')]
        public ?string $toolChoice = null,
    ) {}
}
