<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointTranslationsInterface
{
    public function translations(array $options):array;
}