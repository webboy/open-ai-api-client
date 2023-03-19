<?php

namespace Webboy\OpenAiApiClient\Endpoints\Interfaces;

interface EndpointTranscriptionsInterface
{
    public function transcriptions(array $options):array;
}