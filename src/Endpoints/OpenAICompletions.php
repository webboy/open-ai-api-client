<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAICompletions extends OpenAIClient implements Interfaces\EndpointCreateInterface
{

    public function __construct(string $apiKey, ?Client $client = null)
    {
        parent::__construct($apiKey, $client);
    }

    /**
     * @throws GuzzleException
     */
    public function create(array $data): array
    {
        $endpoint = 'completions';
        return $this->sendRequest('POST', $endpoint,$data);
    }
}