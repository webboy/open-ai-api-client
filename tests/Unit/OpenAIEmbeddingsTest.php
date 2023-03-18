<?php
namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIEmbeddings;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIEmbeddingsTest extends OpenAIUnitTestCase
{

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateEmbeddings()
    {
        $openAIEmbeddings = new OpenAIEmbeddings($this->apiKey);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEmbeddings->create(['input' => 'The quick brown fox jumps over the lazy dog']);

        // Test with missing 'input' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIEmbeddings->create(['model' => 'text-davinci-002']);

        // Test with a valid request
        $options = [
            'model' => 'text-davinci-002',
            'input' => 'The quick brown fox jumps over the lazy dog'
        ];

        $response = $openAIEmbeddings->create($options);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('usage', $response);
        $this->assertArrayHasKey('vectors', $response);
    }
}
