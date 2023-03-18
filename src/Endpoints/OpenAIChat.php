<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIChat extends OpenAIClient implements EndpointCreateInterface
{

    public function __construct(string $apiKey, ?Client $client = null)
    {
        parent::__construct($apiKey, $client);
    }
    
    public function create(array $options): array
    {
        // TODO: Implement create() method.
    }
}