<?php

namespace Mmorand\Apertus\Dto\Chat;

use Mmorand\Apertus\Enums\Role;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;
use Spatie\LaravelData\DataCollection;

class ChatMessage extends SpatieData
{
    /** @param DataCollection<int, ToolCalls>|null $toolCalls */
    public function __construct(
        public Role $role,
        public string $content,
        public ?string $name = null,
        #[MapName('tool_call_id')]
        public ?string $toolCallId = null,
        #[MapName('tool_calls')]
        #[DataCollectionOf(ToolCalls::class)]
        public ?DataCollection $toolCalls = null,
    ) {}
}
