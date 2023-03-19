<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointDeleteInterface
{
    public function delete(string $id): array;
}
