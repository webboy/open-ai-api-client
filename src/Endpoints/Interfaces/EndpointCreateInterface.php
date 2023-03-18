<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointCreateInterface
{
    function create(array $data):array;
}