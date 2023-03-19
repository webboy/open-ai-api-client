<?php
namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIEdits;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIEditsTest extends OpenAIUnitTestCase
{
    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateEdit()
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

        $openAIEdits = new OpenAIEdits($this->apiKey,$guzzleClient);

        // Test with a valid request
        $options = [
            'model' => 'text-davinci-edit-001',
            'input' => 'The cats was playing in the garden.',
            'instruction' => 'Fix any grammatical errors.'
        ];

        $response = $openAIEdits->create($options);
        $this->assertArrayHasKey('choices', $response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('usage', $response);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEdits->create(['instruction' => 'Fix any grammatical errors.']);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMoreException()
    {
        $openAIEdits = new OpenAIEdits($this->apiKey);

        // Test with missing 'instruction' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEdits->create(['model' => 'some-model']);
    }
}
