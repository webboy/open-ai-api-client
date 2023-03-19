<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
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

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
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

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
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

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
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