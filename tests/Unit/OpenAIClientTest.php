<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use ReflectionException;
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

    /**
     * @return void
     * @throws ReflectionException
     */
    public function testSetTimeout(): void
    {
        $client = new OpenAIClient($this->apiKey);

        $timeout = 5.0;
        $client->setTimeout($timeout);

        $clientProperty = (new \ReflectionClass($client))->getProperty('timeout');
        $clientProperty->setAccessible(true);

        $this->assertSame($timeout, $clientProperty->getValue($client));
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function testSetConnectTimeout(): void
    {
        $client = new OpenAIClient($this->apiKey);

        $connectTimeout = 10.0;
        $client->setConnectTimeout($connectTimeout);

        $clientProperty = (new \ReflectionClass($client))->getProperty('connectTimeout');
        $clientProperty->setAccessible(true);

        $this->assertSame($connectTimeout, $clientProperty->getValue($client));
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function testSetHttpErrors(): void
    {
        $client = new OpenAIClient($this->apiKey);

        $httpErrors = false;
        $client->setHttpErrors($httpErrors);

        $clientProperty = (new \ReflectionClass($client))->getProperty('httpErrors');
        $clientProperty->setAccessible(true);

        $this->assertSame($httpErrors, $clientProperty->getValue($client));
    }
}