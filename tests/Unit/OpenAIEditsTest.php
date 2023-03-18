<?php
namespace Unit;

use GuzzleHttp\Exception\GuzzleException;
use OpenAIUnitTestCase;
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
        $openAIEdits = new OpenAIEdits($this->apiKey);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEdits->create(['instruction' => 'Fix any grammatical errors.']);

        // Test with missing 'instruction' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEdits->create(['model' => 'text-davinci-edit-001']);

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
    }
}
