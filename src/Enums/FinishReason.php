<?php

namespace Mmorand\Apertus\Enums;

enum FinishReason: string
{
    case stop = 'stop';
    case length = 'length';
    case tool_calls = 'tool_calls';
    case content_filter = 'content_filter';
    case function_call = 'function_call';
}
