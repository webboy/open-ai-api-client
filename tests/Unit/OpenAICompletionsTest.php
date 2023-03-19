<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAICompletions;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAICompletionsTest extends OpenAIUnitTestCase
{
    /**
     * @throws OpenAIClientException|GuzzleException
     */
    public function testCreateCompletion(): void
    {
        $mockResponse = [
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

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $completionsClient = new OpenAICompletions($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options['model'] = 'text-davinci-002';
        $options['prompt'] = 'Once upon a time';

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

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $completionsClient->create(['messages' => [['role' => 'system', 'content' => 'You are a helpful assistant.']]]);
    }
}
