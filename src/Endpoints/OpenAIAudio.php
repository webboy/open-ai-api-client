<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointTranscriptionsInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointTranslationsInterface;

class OpenAIAudio extends OpenAIClient implements
    EndpointTranscriptionsInterface,
    EndpointTranslationsInterface
{
    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function transcriptions(array $options): array
    {
        if (!isset($options['file'])) {
            throw new OpenAIInvalidParameterException(message: 'The "file" option is required.');
        }

        if (!isset($options['model'])) {
            throw new OpenAIInvalidParameterException(message: 'The "model" option is required.');
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

        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        return $this->sendRequest(method: 'POST', endpoint: $endpoint, data: $filteredOptions);
    }

    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function translations(array $options): array
    {
        if (!isset($options['file'])) {
            throw new OpenAIInvalidParameterException(message: 'The "file" option is required.');
        }

        if (!isset($options['model'])) {
            throw new OpenAIInvalidParameterException(message: 'The "model" option is required.');
        }

        $endpoint = 'audio/translations';

        $allowedOptions = [
            'file',
            'model',
            'prompt',
            'response_format',
            'temperature'
        ];

        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        return $this->sendRequest(method: 'POST', endpoint: $endpoint, data: $filteredOptions);
    }
}
