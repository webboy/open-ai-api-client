<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIModels extends OpenAIClient
{
    public function __construct(string $apiKey, ?Client $client = null)
    {
        parent::__construct($apiKey, $client);
    }

    /**
     * @throws GuzzleException|OpenAIClientException
     */
    public function list(): array
    {
        $endpoint = 'models';
        return $this->sendRequest('GET', $endpoint);
    }

    /**
     * @throws GuzzleException|OpenAIClientException
     */
    public function get(string $id): array
    {
        $endpoint = 'models/'.$id;
        return $this->sendRequest('GET', $endpoint);
    }
}