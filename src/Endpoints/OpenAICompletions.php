<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Attributes\ThrowsAttribute;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAICompletions extends OpenAIClient implements EndpointCreateInterface
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

        $endpoint = 'completions';

        $allowedOptions = [
            'model',
            'prompt',
            'max_tokens',
            'temperature',
            'top_p',
            'n',
            'stream',
            'logprobs',
            'echo',
            'stop',
            'presence_penalty',
            'frequency_penalty',
            'best_of',
            'logit_bias',
            'user',
        ];

        // Filter options to only include allowed keys
        $filteredOptions = $this->filterOptions(options: $options, allowedOptions: $allowedOptions);

        return $this->sendRequest(method: 'POST', endpoint: $endpoint, data: $filteredOptions);
    }
}
