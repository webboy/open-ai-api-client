<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIClientTest extends OpenAIUnitTestCase
{
    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws ClientExceptionInterface
     */
    public function testSendRequest(): void
    {
        // Create a mock response
        $mockResponse = [
            'message' => 'Success',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIClient with the mocked Guzzle client
        $client = new OpenAIClient($this->apiKey,$guzzleClient);

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
        // Create a MockHandler with an exception
        $mockHandler = new MockHandler([
            new RequestException(
                'API request failed with status code 500',
                new Request('GET', 'test/endpoint')
            ),
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAIClient with the mocked Guzzle client
        $client = new OpenAIClient($this->apiKey, $guzzleClient);

        // Expect an OpenAIClientException
        $this->expectException(OpenAIClientException::class);
        $this->expectExceptionMessage(OpenAIClientException::class.': API request failed with status code 500');

        // Call the sendRequest method
        $client->sendRequest('GET', 'test/endpoint');
    }
}