<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointTranscriptionsInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointTranslationsInterface;

class OpenAIAudio extends OpenAIClient implements
    EndpointTranscriptionsInterface,
    EndpointTranslationsInterface
{
    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
    public function transcriptions(array $options): array
    {
        if (!isset($options['file'])) {
            throw new OpenAIInvalidParameterException('The "file" option is required.');
        }

        if (!isset($options['model'])) {
            throw new OpenAIInvalidParameterException('The "model" option is required.');
        }

        $endpoint = 'audio/transcriptions';

        $allowedOptions = [
            'file',
            'model',
            'prompt',
            'response_format',
            'temperature',
            'language'
        ];

        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
    public function translations(array $options): array
    {
        if (!isset($options['file'])) {
            throw new OpenAIInvalidParameterException('The "file" option is required.');
        }

        if (!isset($options['model'])) {
            throw new OpenAIInvalidParameterException('The "model" option is required.');
        }

        $endpoint = 'audio/translations';

        $allowedOptions = [
            'file',
            'model',
            'prompt',
            'response_format',
            'temperature'
        ];

        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }
}