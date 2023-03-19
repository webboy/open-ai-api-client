<?php

namespace Webboy\OpenAiApiClient\Exceptions;

use Exception;
use Throwable;

class OpenAIClientException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(self::class . ': ' . $message, $code, $previous);
    }
}
