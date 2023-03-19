<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointVariationsInterface
{
    public function variations(array $options): array;
}
