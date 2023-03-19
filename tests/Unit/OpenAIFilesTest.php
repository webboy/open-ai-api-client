<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIFiles;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIFilesTest extends OpenAIUnitTestCase
{
    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testList()
    {
        $mockResponse = [
            'data' => [],
            'object' => 'list',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIFiles = new OpenAIFiles($this->apiKey, $guzzleClient);

        $response = $openAIFiles->list();

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('object', $response);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreate()
    {
        $mockResponse = [
            'id' => 'file-123',
            'object' => 'file',
            'bytes' => 123,
            'created_at' => 1613779121,
            'filename' => 'mydata.jsonl',
            'purpose' => 'fine-tune',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIFiles = new OpenAIFiles($this->apiKey, $guzzleClient);

        $options = [
            'file' => '/path/to/your/file.jsonl',
            'purpose' => 'fine-tune',
        ];

        $response = $openAIFiles->create($options);

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('bytes', $response);
        $this->assertArrayHasKey('created_at', $response);
        $this->assertArrayHasKey('filename', $response);
        $this->assertArrayHasKey('purpose', $response);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testGet()
    {
        $mockResponse = [
            'id' => 'file-123',
            'object' => 'file',
            'bytes' => 123,
            'created_at' => 1613779121,
            'filename' => 'mydata.jsonl',
            'purpose' => 'fine-tune',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIFiles = new OpenAIFiles($this->apiKey, $guzzleClient);

        $fileId = 'file-123';
        $response = $openAIFiles->get($fileId);

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('bytes', $response);
        $this->assertArrayHasKey('created_at', $response);
        $this->assertArrayHasKey('filename', $response);
        $this->assertArrayHasKey('purpose', $response);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testDelete()
    {
        $mockResponse = [
            'id' => 'file-123',
            'object' => 'file',
            'bytes' => 123,
            'created_at' => 1613779121,
            'filename' => 'mydata.jsonl',
            'purpose' => 'fine-tune',
            'deleted' => true,
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIFiles = new OpenAIFiles($this->apiKey, $guzzleClient);

        $fileId = 'file-123';
        $response = $openAIFiles->delete($fileId);

        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testContent()
    {
        $mockResponse = [
            'id' => 'file-123',
            'object' => 'file',
            'bytes' => 123,
            'created_at' => 1613779121,
            'filename' => 'mydata.jsonl',
            'purpose' => 'fine-tune',
            'content' => 'This is a content example.',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        $openAIFiles = new OpenAIFiles($this->apiKey, $guzzleClient);

        $fileId = 'file-123';
        $response = $openAIFiles->content($fileId);

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('object', $response);
        $this->assertArrayHasKey('bytes', $response);
        $this->assertArrayHasKey('created_at', $response);
        $this->assertArrayHasKey('filename', $response);
        $this->assertArrayHasKey('purpose', $response);
        $this->assertArrayHasKey('content', $response);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateMissingFileOption()
    {
        $openAIFiles = new OpenAIFiles($this->apiKey);

        // Test with missing 'file' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIFiles->create(['purpose' => 'fine-tune']);
    }

    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testCreateMissingPurposeOption()
    {
        $openAIFiles = new OpenAIFiles($this->apiKey);

        // Test with missing 'purpose' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIFiles->create(['file' => 'path/to/data_file.jsonl']);
    }

}

