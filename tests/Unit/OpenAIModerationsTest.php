<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIModerations;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIModerationsTest extends OpenAIUnitTestCase
{

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateModeration()
    {
        $mockResponse = [
            'results' => [],
            'id' => 'mock-id',
            'object' => 'moderation.result',
            'created' => 1628612669,
            'model' => 'text-moderation-latest',
            'usage' => ['prompt_tokens' => 12, 'completion_tokens' => 0, 'total_tokens' => 12],
        ];

        // Create a Guzzle client with the handler stack
        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $openAIModerations = new OpenAIModerations($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'input' => 'This is a test input.'
        ];

        $response = $openAIModerations->create($options);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('usage', $response);

        // Test with missing 'input' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIModerations->create();
    }
}
