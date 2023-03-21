<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIModerations extends OpenAIClient implements EndpointCreateInterface
{
    /**
     * @param array $options
     * @return array

     * @throws OpenAIClientException
     */
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
        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        // Set default model if not provided
        if (!isset($filteredOptions['model'])) {
            $filteredOptions['model'] = 'text-moderation-latest';
        }

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }
}
