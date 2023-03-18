<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointCancelInterface
{
    public function cancel(string $id):array;
}