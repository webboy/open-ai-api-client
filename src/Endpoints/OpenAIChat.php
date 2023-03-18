<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;

class OpenAIChat extends \Webboy\OpenAiApiClient\OpenAIClient implements Interfaces\EndpointCreateInterface
{

    public function __construct(string $apiKey, ?Client $client = null)
    {
        parent::__construct($apiKey, $client);
    }
    
    public function create(array $data): array
    {
        // TODO: Implement create() method.
    }
}