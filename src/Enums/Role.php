<?php

namespace Mmorand\Apertus\Enums;

enum Role: string
{
    case assistant = 'assistant';
    case system = 'system';
    case user = 'user';
}
