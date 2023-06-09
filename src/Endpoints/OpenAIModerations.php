<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIModerations extends OpenAIClient implements EndpointCreateInterface
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
        // Check if required 'input' option is present
        if (!isset($options['input'])) {
            throw new OpenAIInvalidParameterException('The "input" option is required.');
        }

        $endpoint = 'moderations';

        $allowedOptions = [
            'input',
            'model',
        ];

        // Filter options to only include allowed keys
        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        // Set default model if not provided
        if (!isset($filteredOptions['model'])) {
            $filteredOptions['model'] = 'text-moderation-latest';
        }

        return $this->sendRequest(method: 'POST', endpoint: $endpoint, data: $filteredOptions);
    }
}
