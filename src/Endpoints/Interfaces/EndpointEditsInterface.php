<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointEditsInterface
{
    public function edits(array $options): array;
}
