<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointEventsInterface
{
    public function events(string $id):array;
}