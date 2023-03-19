<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIImages;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIImagesTest extends OpenAIUnitTestCase
{

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testGenerations()
    {
        $mockResponse = [
            'created' => 1589478378,
            'data' => [
                ['url' => 'https://...'],
                ['url' => 'https://...']
            ]
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIImages with the mocked Guzzle client
        $openAIImages = new OpenAIImages($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'prompt' => 'A cute baby sea otter',
            'n' => 2,
            'size' => '1024x1024'
        ];

        $response = $openAIImages->generations($options);

        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('data', $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingPromptOption()
    {
        $openAIImages = new OpenAIImages($this->apiKey);

        // Test with missing 'prompt' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIImages->generations([]);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testEdits()
    {
        $mockResponse = [
            'created' => 1589478378,
            'data' => [
                ['url' => 'https://...'],
                ['url' => 'https://...']
            ]
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIImages with the mocked Guzzle client
        $openAIImages = new OpenAIImages($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'image' => 'valid_image_path.png',
            'prompt' => 'A cute baby sea otter wearing a beret',
            'n' => 2,
            'size' => '1024x1024'
        ];

        $response = $openAIImages->edits($options);

        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('data', $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingImageOptionInEdits()
    {
        $openAIImages = new OpenAIImages($this->apiKey);

        // Test with missing 'image' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIImages->edits([]);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingPromptOptionInEdits()
    {
        $openAIImages = new OpenAIImages($this->apiKey);

        // Test with missing 'image' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIImages->edits(['image'=>'test image']);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testVariations()
    {
        $mockResponse = [
            'created' => 1589478378,
            'data' => [
                ['url' => 'https://...'],
                ['url' => 'https://...']
            ]
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIImages with the mocked Guzzle client
        $openAIImages = new OpenAIImages($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'image' => 'valid_image_path.png',
            'n' => 2,
            'size' => '1024x1024'
        ];

        $response = $openAIImages->variations($options);

        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('data', $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingImageOptionInVariations()
    {
        $openAIImages = new OpenAIImages($this->apiKey);

        // Test with missing 'image' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIImages->variations([]);
    }

}
