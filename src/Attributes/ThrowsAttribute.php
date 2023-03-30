<?php

namespace Webboy\OpenAiApiClient\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ThrowsAttribute
{
    public function __construct(
        private string $exceptionClass,
        private string $description
    ) {
    }

    public function getExceptionClass(): string
    {
        return $this->exceptionClass;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
