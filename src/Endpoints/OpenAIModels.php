<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointGetInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointListInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIModels extends OpenAIClient implements EndpointGetInterface, EndpointListInterface
{
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
        $endpoint = 'models/' . $id;
        return $this->sendRequest('GET', $endpoint);
    }
}
