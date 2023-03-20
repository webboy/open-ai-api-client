<?php

namespace Webboy\OpenAiApiClient\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointContentInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointCreateInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointDeleteInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointGetInterface;
use Webboy\OpenAiApiClient\Endpoints\Interfaces\EndpointListInterface;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;
use Webboy\OpenAiApiClient\Exceptions\OpenAIInvalidParameterException;
use Webboy\OpenAiApiClient\OpenAIClient;

class OpenAIFiles extends OpenAIClient implements
    EndpointCreateInterface,
    EndpointListInterface,
    EndpointDeleteInterface,
    EndpointGetInterface,
    EndpointContentInterface
{
    /**

     * @throws OpenAIClientException
     * @throws OpenAIInvalidParameterException
     */
    public function create(array $options): array
    {
        if (!isset($options['file'])) {
            throw new OpenAIInvalidParameterException('file is required');
        }

        if (!isset($options['purpose'])) {
            throw new OpenAIInvalidParameterException('purpose is required');
        }

        $allowedOptions = ['file', 'purpose'];
        $filteredOptions = $this->filterOptions($options, $allowedOptions);

        $endpoint = 'files';

        return $this->sendRequest('POST', $endpoint, $filteredOptions);
    }

    /**

     * @throws OpenAIClientException
     */
    public function delete(string $id): array
    {
        $endpoint = 'files/' . $id;

        return $this->sendRequest('DELETE', $endpoint);
    }

    /**

     * @throws OpenAIClientException
     */
    public function get(string $id): array
    {
        $endpoint = 'files/' . $id;

        return $this->sendRequest('GET', $endpoint);
    }

    /**

     * @throws OpenAIClientException
     */
    public function list(): array
    {
        $endpoint = 'files';

        return $this->sendRequest('GET', $endpoint);
    }

    /**

     * @throws OpenAIClientException
     */
    public function content(string $id): array
    {
        $endpoint = 'files/' . $id . '/content';

        return $this->sendRequest('GET', $endpoint);
    }
}
