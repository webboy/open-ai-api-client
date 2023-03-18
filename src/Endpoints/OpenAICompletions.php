<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAICompletions extends OpenAIClient
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
     * @param string $model
     * @param array $options
     * @return array
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function createCompletion(
        string            $model,
        array            $options = []
    ): array
    {
        $endpoint = 'completions';

        $allowedOptions = [
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

        $data = array_merge(
            ['model' => $model],
            $filteredOptions
        );

        return $this->sendRequest('POST', $endpoint, $data);
    }
}