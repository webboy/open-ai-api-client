<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class OpenAIUnitTestCase extends TestCase
{
    protected string $apiKey;

    protected function setUp(): void
    {
        $this->apiKey = 'no_api_key_needed';
    }

    public function prepareMockGuzzleClient(array $mockResponse): Client
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($mockResponse)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        return new Client(['handler' => $handlerStack]);
    }
}