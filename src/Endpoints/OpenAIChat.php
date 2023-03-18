<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIChat extends OpenAIClient
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