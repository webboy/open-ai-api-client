<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointGenerationsInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointVariationsInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointEditsInterface;

class OpenAIImages extends OpenAIClient implements
    EndpointGenerationsInterface,
    EndpointVariationsInterface,
    EndpointEditsInterface
{
    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function generations(array $options): array
    {
        if (!isset($options['prompt'])) {
            throw new OpenAIInvalidParameterException('The "prompt" option is required.');
        }

        $endpoint = 'images/generations';

        $allowedOptions = [
            'prompt',
            'n',
            'size',
            'response_format',
            'user',
        ];

        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }

    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function edits(array $options): array
    {
        if (!isset($options['image'])) {
            throw new OpenAIInvalidParameterException('The "image" option is required.');
        }

        if (!isset($options['prompt'])) {
            throw new OpenAIInvalidParameterException('The "prompt" option is required.');
        }

        $endpoint = 'images/edits';

        $allowedOptions = [
            'image',
            'mask',
            'prompt',
            'n',
            'size',
            'response_format',
            'user',
        ];

        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }

    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function variations(array $options): array
    {
        if (!isset($options['image'])) {
            throw new OpenAIInvalidParameterException('The "image" option is required.');
        }

        $endpoint = 'images/variations';

        $allowedOptions = [
            'image',
            'n',
            'size',
            'response_format',
            'user',
        ];

        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }
}
