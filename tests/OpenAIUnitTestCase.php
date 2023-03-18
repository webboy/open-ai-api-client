<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class OpenAIUnitTestCase extends TestCase
{
    protected string $apiKey;

    protected function setUp(): void
    {
        $this->apiKey = 'no_api_key_needed';
    }
}