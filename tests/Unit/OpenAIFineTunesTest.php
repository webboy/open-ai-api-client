<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIFineTunes;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIFineTunesTest extends OpenAIUnitTestCase
{
    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testCreateFineTune()
    {
        $openAIFineTunes = new OpenAIFineTunes($this->apiKey);

        // Test with missing 'training_file' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIFineTunes->create();

        // Test with a valid request
        $options = [
            'training_file' => 'file_id',
        ];

        // You need to replace 'file_id' with a valid file ID to run this test
        $response = $openAIFineTunes->create($options);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('status', $response);
    }

    /**
     * @throws GuzzleException|OpenAIClientException
     */
    public function testGetFineTune(): void
    {
        $apiKey = 'test_api_key';
        $fineTuneID = 'fine_tune_id';

        $data_array = [
            'id' => $fineTuneID,
            'object' => 'fine_tune',
            'created' => time(),
            'status' => 'enqueued',
        ];

        // Create a mock response
        $mockResponse = new Response(200, [], json_encode($data_array));

        // Create a MockHandler and add the mock response
        $mockHandler = new MockHandler([
            $mockResponse,
        ]);

        // Create a HandlerStack with the mock handler
        $handlerStack = HandlerStack::create($mockHandler);

        // Create a Guzzle client with the handler stack
        $guzzleClient = new Client(['handler' => $handlerStack]);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $modelsClient = new OpenAIFineTunes($apiKey, $guzzleClient);

        // Call the get method
        $response = $modelsClient->get($fineTuneID);

        // Assert that the response matches the expected result
        $this->assertSame(
            $data_array,
            $response
        );
    }
}
