<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointContentInterface
{
    public function content(string $id):array;
}