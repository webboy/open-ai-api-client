<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointGenerationsInterface
{
    public function generations(array $options):array;
}