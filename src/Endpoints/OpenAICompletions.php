<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAICompletions extends OpenAIClient implements EndpointCreateInterface
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
    public function create(array $options  = []): array
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
        $filteredOptions = array_intersect_key($options, array_flip($allowedOptions));

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }
}