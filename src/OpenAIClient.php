<?php

namespace Webboy\OpenAiApiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Webboy\OpenAiApiClient\Attributes\MethodDescriptionAttribute;
use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;

class OpenAIClient
{
    protected Client $client;
    protected float $timeout = 0.0;
    protected float $connectTimeout = 0.0;
    protected bool $httpErrors = true;

    #[MethodDescriptionAttribute(description: 'OpenAI constructor')]
    public function __construct(
        private string $apiKey,
        ?Client $client = null,
        private string $baseUrl = 'https://api.openai.com/v1/'
    ) {
        $this->client = $client ?? new Client([
            'base_uri'  => $this->baseUrl,
            'verify'    => false
        ]);
    }

    #[MethodDescriptionAttribute(description: 'Set the request timeout.')]
    public function setTimeout(float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    #[MethodDescriptionAttribute(description: 'Set the connection timeout.')]
    public function setConnectTimeout(float $connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    #[MethodDescriptionAttribute(description: 'Set whether to throw exceptions on HTTP errors.')]
    public function setHttpErrors(bool $httpErrors): self
    {
        $this->httpErrors = $httpErrors;

        return $this;
    }

    #[MethodDescriptionAttribute(description: 'Send an HTTP request to the specified endpoint with the given data.')]
    #[ThrowsAttribute(OpenAIClientException::class, 'In case of client exception')]
    public function sendRequest(
        $method,
        $endpoint,
        array $data = []
    ): mixed {
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

            if (!empty($data)) {
                $options['json']    = $data;
            }

            $response = $this->client->request(
                method: $method,
                uri: $endpoint,
                options: $options
            );

            return json_decode($response->getBody(), true);
        } catch (RequestException | GuzzleException $e) {
            throw new OpenAIClientException($e->getMessage());
        }
    }

    #[MethodDescriptionAttribute(description: 'Filter the input array options')]
    protected function filterOptions(
        array $options,
        array $allowedOptions
    ): array {
        return array_intersect_key($options, array_flip($allowedOptions));
    }
}
