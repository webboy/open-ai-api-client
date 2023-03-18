<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAICompletions;

class OpenAICompletionsTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testCreateCompletion(): void
    {
        $apiKey = 'test_api_key';

        // Create a mock response
        $mockResponse = new Response(200, [], json_encode([
            'id' => 'completion_1',
            'object' => 'completion',
            'choices' => [
                [
                    'text' => 'Test response',
                ],
            ],
        ]));

        // Create a MockHandler and add the mock response
        $mockHandler = new MockHandler([
            $mockResponse,
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAICompletions with the mocked Guzzle client
        $completionsClient = new OpenAICompletions($apiKey, $guzzleClient);

        // Define the data to send
        $data = [
            'model' => 'text-davinci-002',
            'prompt' => 'Hello,',
            'max_tokens' => 5,
        ];

        // Call the create method
        $response = $completionsClient->create($data);

        // Assert that the response matches the expected result
        $this->assertSame(
            [
                'id' => 'completion_1',
                'object' => 'completion',
                'choices' => [
                    [
                        'text' => 'Test response',
                    ],
                ],
            ],
            $response
        );
    }
}

