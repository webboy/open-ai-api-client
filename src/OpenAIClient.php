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

    public function __construct(
        private string $apiKey,
        ?Client $client = null
    )
    {
        $this->client = $client ?? new Client(['base_uri' => $this->baseUrl]);
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function sendRequest($method, $endpoint, $data = [])
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