# PHP OpenAI API Client

A simple community-maintained PHP client library for interacting with the OpenAI API. This package provides an easy way to use OpenAI's GPT models for tasks such as text generation and completion.

Please note that this is an unofficial library.

This library is handy because it returns back a raw response as array which can then be used by any kind of adapter class.

## Requirements

- PHP 8.0 or higher
- Guzzle HTTP client

## Installation

You can install the package via Composer:

```bash
composer require webboy/open-ai-api-client
```

## Usage examples

First, create an instance of the `Endpoint` classes with your API key:

```php
require_once('vendor/autoload.php');

use Dotenv\Dotenv;
use Webboy\OpenAiApiClient\Endpoints\OpenAICompletions;
use Webboy\OpenAiApiClient\Exceptions\OpenAIClientException;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];

$client = new OpenAICompletions($apiKey);

$options['model']   = 'text-davinci-003';
$options['prompt']  = 'What time is it?';

try {
    print_r($client->create($options));
} catch (OpenAIClientException $exception) {
    die('OpenAI error occured: '.$exception->getMessage());
}
```
The above code will generate something like this:

```text
Array
(
    [id] => cmpl-6wAQB0aPhvbxMAyIdz98z8jpPeKdq
    [object] => text_completion
    [created] => 1679321103
    [model] => text-davinci-003
    [choices] => Array
        (
            [0] => Array
                (
                    [text] =>It is 6:25 PM.
                    [index] => 0
                    [logprobs] =>
                    [finish_reason] => stop
                )
        )
    [usage] => Array
        (
            [prompt_tokens] => 5
            [completion_tokens] => 9
            [total_tokens] => 14
        )
)
```

## Testing
Endpoint classes are created to accept HTTP client as a parameter, which enables mocking tests to be performed without making real API calls. If you need to make real API calls, feel free to create a testuit.
To run PHPUnit tests:

```php
./vendor/bin/phpunit

```

## License
The PHP OpenAI API Client is open-sourced software licensed under the MIT license.
