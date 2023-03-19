<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointGetInterface
{
    public function get(string $id): array;
}
