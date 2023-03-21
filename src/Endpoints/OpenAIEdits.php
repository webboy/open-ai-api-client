<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIEdits extends OpenAIClient implements EndpointCreateInterface
{
    /**
     * @param array $options
     * @return array

     * @throws OpenAIClientException
     */
    public function create(array $options = []): array
    {
        // Check if required options are present
        if (!isset($options['model'])) {
            throw new OpenAIInvalidParameterException('The "model" option is required.');
        }
        if (!isset($options['instruction'])) {
            throw new OpenAIInvalidParameterException('The "instruction" option is required.');
        }

        $endpoint = 'edits';

        $allowedOptions = [
            'model',
            'input',
            'instruction',
            'n',
            'temperature',
            'top_p',
        ];

        // Filter options to only include allowed keys
        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }
}
