<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
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
        $mockResponse = [
            'object' => 'fine_tune',
            'created' => time(),
            'status' => 'enqueued',
        ];

        // Create a Guzzle client with the handler stack
        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIFineTunes = new OpenAIFineTunes($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'training_file' => 'file_id',
        ];

        // You need to replace 'file_id' with a valid file ID to run this test
        $response = $openAIFineTunes->create($options);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('status', $response);

        // Test with missing 'training_file' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIFineTunes->create();
    }

    /**
     * @throws GuzzleException|OpenAIClientException
     */
    public function testGetFineTune(): void
    {
        $apiKey = 'test_api_key';
        $fineTuneID = 'fine_tune_id';

        $mockResponse = [
            'id' => $fineTuneID,
            'object' => 'fine_tune',
            'created' => time(),
            'status' => 'enqueued',
        ];

        // Create a Guzzle client with the handler stack
        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIModels with the mocked Guzzle client
        $openAIFineTunes = new OpenAIFineTunes($apiKey, $guzzleClient);

        // Call the get method
        $response = $openAIFineTunes->get($fineTuneID);

        // Assert that the response matches the expected result
        $this->assertSame(
            $mockResponse,
            $response
        );
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testListFineTunes(): void
    {
        $mockResponse = [
            'object' => 'list',
            'data' => [
                [
                    'id' => 'fine_tune_id',
                    'object' => 'fine_tune',
                    'created' => time(),
                    'status' => 'enqueued',
                ],
            ],
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);
        $openAIFineTunes = new OpenAIFineTunes($this->apiKey, $guzzleClient);

        $response = $openAIFineTunes->list();

        $this->assertSame($mockResponse, $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testCancelFineTune(): void
    {
        $fineTuneID = 'fine_tune_id';

        $mockResponse = [
            'id' => $fineTuneID,
            'object' => 'fine_tune',
            'created' => time(),
            'status' => 'cancelled',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);
        $openAIFineTunes = new OpenAIFineTunes($this->apiKey, $guzzleClient);

        $response = $openAIFineTunes->cancel($fineTuneID);

        $this->assertSame($mockResponse, $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testEvents(): void
    {
        $fineTuneID = 'fine_tune_id';

        $mockResponse = [
            'object' => 'list',
            'data' => [
                [
                    'id' => 'event_id',
                    'object' => 'event',
                    'created' => time(),
                    'event_type' => 'example_event',
                ],
            ],
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);
        $openAIFineTunes = new OpenAIFineTunes($this->apiKey, $guzzleClient);

        $response = $openAIFineTunes->events($fineTuneID);

        $this->assertSame($mockResponse, $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testDeleteFineTune(): void
    {
        $fineTuneID = 'fine_tune_id';

        $mockResponse = [
            'id' => $fineTuneID,
            'object' => 'fine_tune',
            'created' => time(),
            'status' => 'deleted',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);
        $openAIFineTunes = new OpenAIFineTunes($this->apiKey, $guzzleClient);

        $response = $openAIFineTunes->delete($fineTuneID);

        $this->assertSame($mockResponse, $response);
    }
}
