<?php

namespace Mmorand\Apertus\Dto\Chat;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;
use Spatie\LaravelData\DataCollection;

class ChatCompletionResponse extends SpatieData
{
    /** @param DataCollection<int, ChatCompletionChoice> $choices */
    public function __construct(
        public string $id,
        public string $object,
        public int $created,
        public string $model,
        #[DataCollectionOf(ChatCompletionChoice::class)]
        public DataCollection $choices,
        public ChatCompletionUsage $usage,
        #[MapName('system_fingerprint')]
        public ?string $systemFingerprint = null,
    ) {}
}
