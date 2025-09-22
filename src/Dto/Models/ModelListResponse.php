<?php

namespace Mmorand\Apertus\Dto\Models;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data as SpatieData;

class ModelListResponse extends SpatieData
{
    /** @param array<int, Model> $data */
    public function __construct(
        public string $object,
        #[DataCollectionOf(Model::class)]
        public array $data,
    ) {}
}
