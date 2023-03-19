<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIChat;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIChatTest extends OpenAIUnitTestCase
{

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateChatCompletion()
    {
        $mockResponse = [
            'choices' => [],
            'id' => 'mock-id',
            'object' => 'chat.completion',
            'created' => 1628612669,
            'model' => 'gpt-3.5-turbo',
            'usage' => ['prompt_tokens' => 12, 'completion_tokens' => 0, 'total_tokens' => 12],
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIChat with the mocked Guzzle client
        $openAIChat = new OpenAIChat($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => 'Who won the world series in 2020?']
            ]
        ];

        $response = $openAIChat->create($options);

        $this->assertArrayHasKey('choices', $response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('usage', $response);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIChat->create();
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMoreException()
    {
        $openAIEmbeddings = new OpenAIChat($this->apiKey);

        // Test with missing 'input' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEmbeddings->create(['model' => 'some-model']);
    }
}
