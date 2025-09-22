<?php

namespace Mmorand\Apertus\Enums;

enum Model: string
{
    case apertus8b = 'swiss-ai/apertus-8b-instruct';
    case apertus70b = 'swiss-ai/apertus-70b-instruct';
    case gemma = 'aisingapore/Gemma-SEA-LION-v4-27B-IT';
}
