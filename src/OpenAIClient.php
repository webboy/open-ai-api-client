<?php

namespace Webboy\OpenAiApiClient;

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
     * OpenAIClient constructor.
     *
     * @param string $apiKey
     * @param Client|null $client
     */
    public function __construct(
        private string $apiKey,
        ?Client $client = null
    ) {
        $this->client = $client ?? new Client([
            'base_uri'  => $this->baseUrl,
            'verify'    => false
        ]);
    }

    /**
     * Set the request timeout.
     *
     * @param float $timeout
     * @return OpenAIClient
     */
    public function setTimeout(float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Set the connection timeout.
     *
     * @param float $connectTimeout
     * @return OpenAIClient
     */
    public function setConnectTimeout(float $connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    /**
     * Set whether to throw exceptions on HTTP errors.
     *
     * @param bool $httpErrors
     * @return OpenAIClient
     */
    public function setHttpErrors(bool $httpErrors): self
    {
        $this->httpErrors = $httpErrors;

        return $this;
    }


    /**
     * Send an HTTP request to the specified endpoint with the given data.
     *
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
            $options = [
                'headers' => $headers,
                'timeout' => $this->timeout,
                'connect_timeout' => $this->connectTimeout,
                'http_errors' => $this->httpErrors,
            ];

            if (!empty($data)){
                $options['json']    = $data;
            }

            $response = $this->client->request($method, $endpoint, $options);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new OpenAIClientException($e->getMessage());
        }
    }

    /**
     * @param array $options
     * @param array $allowedOptions
     * @return array
     */
    protected function filterOptions(array $options, array $allowedOptions): array
    {
        return array_intersect_key($options, array_flip($allowedOptions));
    }
}
