<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCancelInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointDeleteInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointEventsInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointGetInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointListInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIFineTunes extends OpenAIClient implements
    EndpointCreateInterface,
    EndpointListInterface,
    EndpointGetInterface,
    EndpointCancelInterface,
    EndpointEventsInterface,
    EndpointDeleteInterface
{
    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
    public function create(array $options = []): array
    {
        if (!isset($options['training_file'])) {
            throw new OpenAIInvalidParameterException('The "training_file" option is required.');
        }

        $endpoint = 'fine-tunes';

        $allowedOptions = [
            'training_file',
            'validation_file',
            'model',
            'n_epochs',
            'batch_size',
            'learning_rate_multiplier',
            'prompt_loss_weight',
            'compute_classification_metrics',
            'classification_n_classes',
            'classification_positive_class',
            'classification_betas',
            'suffix',
        ];

        $filteredOptions = array_intersect_key($options, array_flip($allowedOptions));

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    function list(): array
    {
        $endpoint = 'fine-tunes';
        return $this->sendRequest('GET', $endpoint);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function get(string $id): array
    {
        $endpoint = 'fine-tunes/'.$id;
        return $this->sendRequest('GET', $endpoint);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function cancel(string $id): array
    {
        $endpoint = 'fine-tunes/'.$id.'/cancel';
        return $this->sendRequest('POST', $endpoint);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function events(string $id): array
    {
        $endpoint = 'fine-tunes/'.$id.'/events';
        return $this->sendRequest('GET', $endpoint);
    }

    /**
     * @throws GuzzleException
     * @throws OpenAIClientException
     */
    public function delete(string $id): array
    {
        $endpoint = 'models/'.$id;
        return $this->sendRequest('DELETE', $endpoint);
    }


}
