<?php

namespace Mmorand\Apertus\Dto\Chat;

use Mmorand\Apertus\Enums\FinishReason;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ChatCompletionChoice extends SpatieData
{
    public function __construct(
        public int $index,
        public ChatMessage $message,
        #[MapName('finish_reason')]
        public FinishReason $finishReason,
    ) {}
}
