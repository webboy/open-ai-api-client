<?php
namespace Unit;

use GuzzleHttp\Exception\GuzzleException;
use OpenAIUnitTestCase;
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
        $openAIChat = new OpenAIChat($this->apiKey);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIChat->create(['messages' => [['role' => 'system', 'content' => 'You are a helpful assistant.']]]);

        // Test with missing 'messages' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIChat->create(['model' => 'gpt-3.5-turbo']);

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
    }
}