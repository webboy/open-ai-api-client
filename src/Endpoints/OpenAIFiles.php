<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointContentInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointDeleteInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointGetInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointListInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIFiles extends OpenAIClient implements
    EndpointCreateInterface,
    EndpointListInterface,
    EndpointDeleteInterface,
    EndpointGetInterface,
    EndpointContentInterface
{
    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function create(array $options): array
    {
        if (!isset($options['file'])) {
            throw new OpenAIInvalidParameterException('file is required');
        }

        if (!isset($options['purpose'])) {
            throw new OpenAIInvalidParameterException('purpose is required');
        }

        $allowedOptions = ['file', 'purpose'];
        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        $endpoint = 'files';

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
    public function delete(string $id): array
    {
        $endpoint = 'files/' . $id;

        return $this->sendRequest('DELETE', $endpoint);
    }

    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function get(string $id): array
    {
        $endpoint = 'files/' . $id;

        return $this->sendRequest('GET', $endpoint);
    }

    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function list(): array
    {
        $endpoint = 'files';

        return $this->sendRequest('GET', $endpoint);
    }

    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function content(string $id): array
    {
        $endpoint = 'files/' . $id . '/content';

        return $this->sendRequest('GET', $endpoint);
    }
}
