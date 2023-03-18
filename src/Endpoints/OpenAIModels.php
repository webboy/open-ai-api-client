<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointGetInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointListInterface;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIModels extends OpenAIClient implements EndpointListInterface,EndpointGetInterface
{
    public function __construct(string $apiKey, ?Client $client = null)
    {
        parent::__construct($apiKey, $client);
    }

    /**
     * @throws GuzzleException
     */
    public function list(): array
    {
        $endpoint = 'models';
        return $this->sendRequest('GET', $endpoint);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $id): array
    {
        $endpoint = 'models/'.$id;
        return $this->sendRequest('GET', $endpoint);
    }
}