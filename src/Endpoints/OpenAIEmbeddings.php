<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIEmbeddings extends OpenAIClient implements EndpointCreateInterface
{
    #[ThrowsAttribute(
        exceptionClass: OpenAIClientException::class,
        description: 'In case of client exception'
    )]
    #[ThrowsAttribute(
        exceptionClass: OpenAIInvalidParameterException::class,
        description: 'If required options are missing'
    )]
    public function create(array $options = []): array
    {
        // Check if required options are present
        if (!isset($options['model'])) {
            throw new OpenAIInvalidParameterException('The "model" option is required.');
        }
        if (!isset($options['input'])) {
            throw new OpenAIInvalidParameterException('The "input" option is required.');
        }

        $endpoint = 'embeddings';

        $allowedOptions = [
            'model',
            'input',
            'user',
        ];

        // Filter options to only include allowed keys
        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        return $this->sendRequest(method: 'POST', endpoint: $endpoint, data: $filteredOptions);
    }
}
