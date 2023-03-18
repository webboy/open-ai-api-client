<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIModels;

class OpenAIModelsTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testListModels(): void
    {
        $apiKey = 'test_api_key';

        $data_array = [
            'data' => [
                ['id' => 'model_1', 'object' => 'model'],
                ['id' => 'model_2', 'object' => 'model'],
            ],
        ];

        // Create a mock response
        $mockResponse = new Response(200, [], json_encode($data_array));

        // Create a MockHandler and add the mock response
        $mockHandler = new MockHandler([
            $mockResponse,
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $modelsClient = new OpenAIModels($apiKey, $guzzleClient);

        // Call the list method
        $response = $modelsClient->list();

        // Assert that the response matches the expected result
        $this->assertSame(
            $data_array,
            $response
        );
    }

    /**
     * @throws GuzzleException
     */
    public function testGetModel(): void
    {
        $apiKey = 'test_api_key';
        $modelId = 'model_1';

        $data_array = [
            'id' => $modelId,
            'object' => 'model',
        ];

        // Create a mock response
        $mockResponse = new Response(200, [], json_encode($data_array));

        // Create a MockHandler and add the mock response
        $mockHandler = new MockHandler([
            $mockResponse,
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $modelsClient = new OpenAIModels($apiKey, $guzzleClient);

        // Call the get method
        $response = $modelsClient->get($modelId);

        // Assert that the response matches the expected result
        $this->assertSame(
            $data_array,
            $response
        );
    }
}

