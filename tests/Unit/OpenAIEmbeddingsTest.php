<?php
namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIEmbeddings;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;

class OpenAIEmbeddingsTest extends OpenAIUnitTestCase
{



    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateEmbeddings()
    {
        $mockResponse = [
            'object' => 'list',
            'model' => 'text-embedding-ada-002',
            'data'  => [
                [
                    'object'=>'embedding',
                    'embedding' => [0.0023064255,-0.009327292],
                    'index' => 0,
                ]
            ],
            'usage' => [
                'prompt_tokens' => 10,
                'total_tokens' => 30,
            ],
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIEmbeddings = new OpenAIEmbeddings($this->apiKey,$guzzleClient);

        // Test with a valid request
        $options = [
            'model' => 'text-embedding-ada-002',
            'input' => 'The food was delicious and the waiter...'
        ];

        $response = $openAIEmbeddings->create($options);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('usage', $response);
    }
}
