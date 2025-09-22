<?php

namespace Mmorand\Apertus\Dto\Models;

use Mmorand\Apertus\Enums\Model as ModelEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Model extends SpatieData
{
    public function __construct(
        public string $id,
        public ModelEnum $object,
        public int $created,
        #[MapName('owned_by')]
        public string $ownedBy,
    ) {}
}
