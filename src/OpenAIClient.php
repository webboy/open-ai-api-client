<?php

namespace Webboy\OpenAiApiClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;

class OpenAIClient
{

    protected string $baseUrl = 'https://api.openai.com/v1/';
    protected Client $client;

    protected float $timeout = 0.0;
    protected float $connectTimeout = 0.0;
    protected bool $httpErrors = true;

    /**
     * @param string $apiKey
     * @param Client|null $client
     */
    public function __construct(
        private string $apiKey,
        ?Client $client = null
    )
    {
        $this->client = $client ?? new Client(['base_uri' => $this->baseUrl]);
    }

    /**
     * @param float $timeout
     * @return OpenAIClient
     */
    public function setTimeout(float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param float $connectTimeout
     * @return OpenAIClient
     */
    public function setConnectTimeout(float $connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    /**
     * @param bool $httpErrors
     * @return OpenAIClient
     */
    public function setHttpErrors(bool $httpErrors): self
    {
        $this->httpErrors = $httpErrors;

        return $this;
    }


    /**
     * @param $method
     * @param $endpoint
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function sendRequest($method, $endpoint, array $data = []): mixed
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];

        try {
            $response = $this->client->request($method, $endpoint, [
                'headers' => $headers,
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new OpenAIClientException($e->getMessage());
        }
    }
}