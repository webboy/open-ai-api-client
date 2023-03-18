<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIClientTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testSendRequest(): void
    {
        // Create a mock response
        $mockResponse = new Response(200, [], json_encode([
            'message' => 'Success',
        ]));

        // Create a MockHandler and add the mock response
        $mockHandler = new MockHandler([
            $mockResponse,
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAIClient with the mocked Guzzle client
        $client = new OpenAIClient('test_api_key', client: $guzzleClient);

        // Call the sendRequest method
        $response = $client->sendRequest('GET', 'test/endpoint');

        // Assert that the response matches the expected result
        $this->assertSame(['message' => 'Success'], $response);
    }

    /**
     * @throws GuzzleException
     */
    public function testSendRequestException(): void
    {
        $apiKey = 'test_api_key';

        // Create a MockHandler with an exception
        $mockHandler = new MockHandler([
            new \GuzzleHttp\Exception\RequestException(
                'API request failed with status code 500',
                new \GuzzleHttp\Psr7\Request('GET', 'test/endpoint')
            ),
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAIClient with the mocked Guzzle client
        $client = new OpenAIClient($apiKey, $guzzleClient);

        // Expect an OpenAIClientException
        $this->expectException(OpenAIClientException::class);
        $this->expectExceptionMessage(OpenAIClientException::class.': API request failed with status code 500');

        // Call the sendRequest method
        $client->sendRequest('GET', 'test/endpoint');
    }
}