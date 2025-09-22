<?php

namespace Mmorand\Apertus\Facades;

use Illuminate\Support\Facades\Facade;
use Mmorand\Apertus\Resources\Chat;
use Mmorand\Apertus\Resources\Models;

/**
 * @method static Chat chat()
 * @method static Models models()
 *
 * @see \Mmorand\Apertus\Apertus
 */
class Apertus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mmorand\Apertus\Apertus::class;
    }
}
