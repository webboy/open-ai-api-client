<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIChat extends OpenAIClient implements EndpointCreateInterface
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

        if (!isset($options['messages']) || !is_array($options['messages'])) {
            throw new OpenAIInvalidParameterException('The "messages" option is required and must be an array.');
        }

        $endpoint = 'chat/completions';

        $allowedOptions = [
            'model',
            'messages',
            'temperature',
            'top_p',
            'n',
            'stream',
            'stop',
            'max_tokens',
            'presence_penalty',
            'frequency_penalty',
            'logit_bias',
            'user',
        ];

        // Filter options to only include allowed keys
        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        return $this->sendRequest(method: 'POST', endpoint: $endpoint, data: $filteredOptions);
    }
}
