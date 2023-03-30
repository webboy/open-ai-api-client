<?php

namespace Webboy\OpenAiApiClient\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class MethodDescriptionAttribute
{
    public function __construct(private string $description)
    {
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
