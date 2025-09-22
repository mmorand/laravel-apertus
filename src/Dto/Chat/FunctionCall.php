<?php

namespace Mmorand\Apertus\Dto\Chat;

use Spatie\LaravelData\Data as SpatieData;

class FunctionCall extends SpatieData
{
    /** @param array<string, mixed>|null $parameters */
    public function __construct(
        public string $name,
        public ?string $description,
        public ?array $parameters,
    ) {}
}
