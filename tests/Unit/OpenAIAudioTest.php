<?php

namespace Tests\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Tests\OpenAIUnitTestCase;
use Webboy\OpenAiApiClient\Endpoints\OpenAIAudio;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;

class OpenAIAudioTest extends OpenAIUnitTestCase
{
    /**
     * @throws OpenAIClientException
     * @throws GuzzleException
     */
    public function testTranscriptions()
    {
        $mockResponse = [
            'text' => 'This is a transcription example.',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIAudio with the mocked Guzzle client
        $openAIAudio = new OpenAIAudio($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'file' => 'path/to/audio_file.mp3',
            'model' => 'whisper-1',
        ];

        $response = $openAIAudio->transcriptions($options);

        $this->assertArrayHasKey('text', $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testTranslations()
    {
        $mockResponse = [
            'text' => 'This is a translation example.',
        ];

        $guzzleClient = $this->prepareMockGuzzleClient($mockResponse);

        // Instantiate the OpenAIAudio with the mocked Guzzle client
        $openAIAudio = new OpenAIAudio($this->apiKey, $guzzleClient);

        // Test with a valid request
        $options = [
            'file' => 'path/to/audio_file.mp3',
            'model' => 'whisper-1',
        ];

        $response = $openAIAudio->translations($options);

        $this->assertArrayHasKey('text', $response);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingFileOption()
    {
        $openAIAudio = new OpenAIAudio($this->apiKey);

        // Test with missing 'file' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIAudio->transcriptions(['model' => 'whisper-1']);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingModelOption()
    {
        $openAIAudio = new OpenAIAudio($this->apiKey);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIAudio->transcriptions(['file' => 'path/to/audio_file.mp3']);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingFileOptionWithTranslations()
    {
        $openAIAudio = new OpenAIAudio($this->apiKey);

        // Test with missing 'file' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIAudio->translations(['model' => 'whisper-1']);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function testMissingModelOptionWithTranslations()
    {
        $openAIAudio = new OpenAIAudio($this->apiKey);

        // Test with missing 'model' option
        $this->expectException(OpenAIInvalidParameterException::class);
        $openAIAudio->translations(['file' => 'path/to/audio_file.mp3']);
    }
}