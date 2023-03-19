<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointCreateInterface
{
    public function create(array $options): array;
}
