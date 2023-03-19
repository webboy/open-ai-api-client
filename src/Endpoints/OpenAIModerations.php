<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIModerations extends OpenAIClient implements EndpointCreateInterface
{

    /**
     * @param string $apiKey
     * @param Client|null $client
     */
    public function __construct(string $apiKey, ?Client $client = null)
    {
        parent::__construct($apiKey, $client);
    }

    /**
     * @param array $options
     * @return array
     * @throws GuzzleException
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
        $filteredOptions = array_intersect_key($options, array_flip($allowedOptions));

        // Set default model if not provided
        if (!isset($filteredOptions['model'])) {
            $filteredOptions['model'] = 'text-moderation-latest';
        }

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }
}

