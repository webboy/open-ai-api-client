<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIModels;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;

class OpenAIModelsTest extends OpenAIUnitTestCase
{
    /**
     * @throws GuzzleException|OpenAIClientException
     */
    public function testListModels(): void
    {
        $mockResponse = [
            'data' => [
                ['id' => 'model_1', 'object' => 'model'],
                ['id' => 'model_2', 'object' => 'model'],
            ],
        ];

        // Create a Guzzle client with the handler stack
        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $modelsClient = new OpenAIModels($this->apiKey, $guzzleClient);

        // Call the list method
        $response = $modelsClient->list();

        // Assert that the response matches the expected result
        $this->assertSame(
            $mockResponse,
            $response
        );
    }

    /**
     * @throws GuzzleException|OpenAIClientException
     */
    public function testGetModel(): void
    {
        $apiKey = 'test_api_key';
        $modelId = 'model_1';

        $mockResponse = [
            'id' => $modelId,
            'object' => 'model',
        ];

        // Create a Guzzle client with the handler stack
        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $modelsClient = new OpenAIModels($apiKey, $guzzleClient);

        // Call the get method
        $response = $modelsClient->get($modelId);

        // Assert that the response matches the expected result
        $this->assertSame(
            $mockResponse,
            $response
        );
    }
}

