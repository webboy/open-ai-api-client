<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAICompletions;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAICompletionsTest extends OpenAIUnitTestCase
{
    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testCreateCompletion(): void
    {
        $data_array = [
            'id' => 'test_completion_id',
            'object' => 'completion',
            'created' => time(),
            'model' => 'text-davinci-002',
            'usage' => [
                'prompt_tokens' => 10,
                'completion_tokens' => 20,
                'total_tokens' => 30,
            ],
            'choices' => [
                [
                    'text' => 'Once upon a time, there was a little village.',
                    'index' => 0,
                    'logprobs' => null,
                    'finish_reason' => 'stop',
                ],
            ],
        ];

        $mockResponse = json_encode($data_array);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $mockResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $completionsClient = new OpenAICompletions($this->apiKey, $client);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $completionsClient->create(['messages' => [['role' => 'system', 'content' => 'You are a helpful assistant.']]]);

        // Test with a valid request
        $options['model']   = 'text-davinci-002';
        $options['prompt']  = 'Once upon a time';

        $response = $completionsClient->create($options);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('usage', $response);
        $this->assertArrayHasKey('choices', $response);
        $this->assertCount(1, $response['choices']);
        $this->assertArrayHasKey('text', $response['choices'][0]);
        $this->assertArrayHasKey('index', $response['choices'][0]);
        $this->assertArrayHasKey('logprobs', $response['choices'][0]);
        $this->assertArrayHasKey('finish_reason', $response['choices'][0]);
        $this->assertEquals('test_completion_id', $response['id']);
        $this->assertEquals('completion', $response['object']);
        $this->assertEquals('text-davinci-002', $response['model']);
    }
}

