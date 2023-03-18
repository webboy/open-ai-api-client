# PHP OpenAI API Client

A simple PHP client for interacting with the OpenAI API. This package provides an easy way to use OpenAI's GPT models for tasks such as text generation and completion.

## Requirements

- PHP 8.0 or higher
- Guzzle HTTP client

## Installation

You can install the package via Composer:

```bash
composer require webboy/open-ai-api-client
```

## Usage

First, create an instance of the `OpenAIClient` class with your API key:

```php
use Webboy\OpenAiApiClient\OpenAIClient;

$apiKey = 'your_api_key_here';
$client = new OpenAIClient($apiKey);
```
## List Models
To get a list of available models:

```php
use Webboy\OpenAiApiClient\Endpoints\OpenAIModels;

$models = new OpenAIModels($apiKey);
$response = $models->list();

print_r($response);
```

## Get Model
To get information about a specific model:

```php
$response = $models->get('model_id');

print_r($response);

```

## Create Completion
To create a completion using the OpenAI API:

```php
use Webboy\OpenAiApiClient\Endpoints\OpenAICompletions;

$completions = new OpenAICompletions($apiKey);

$options = [
    'model' => 'text-davinci-002',
    'prompt' => 'Once upon a time,',
    'max_tokens' => 50,
];

$response = $completions->createCompletion($options);

print_r($response);

```

## Testing
Just rune PHPUnit tests:

```php
./vendor/bin/phpunit

```

## License
The PHP OpenAI API Client is open-sourced software licensed under the MIT license.