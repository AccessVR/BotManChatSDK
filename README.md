# An SDK for building AI-backed chatbots with BotMan and Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/orchestratexr/botman-chat-sdk.svg?style=flat-square)](https://packagist.org/packages/orchestratexr/botman-chat-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestratexr/botman-chat-sdk.svg?style=flat-square)](https://packagist.org/packages/orchestratexr/botman-chat-sdk)
[![License](https://img.shields.io/github/license/AccessVR/BotManChatSDK)](https://github.com/AccessVR/BotManChatSDK/blob/main/LICENSE)
![GitHub Actions](https://github.com/AccessVR/BotManChatSDK/actions/workflows/build-assets.yml/badge.svg)

BotManChatSDK is a Laravel package designed for supporting the creation of LLM-backed Chat
Bots using [BotMan](https://github.com/botman/botman), [LLPhant](https://github.com/LLPhant/LLPhant), 
and LLM providers like OpenAI, Anthropic, and Ollama.

## About OrchestrateXR

[OrchestrateXR](https://orchestratexr.com) is the easiest way to create and deploy XR content.
Use your web browser to create for mobile, tablets, PCs and XR devices.

## Roadmap

* [x] Full compatability with existing [BotMan Drivers](https://botman.io/2.0/installation) including Slack 
* [x] Drop-in replacement for [BotMan Web Widget](https://botman.io/2.0/web-widget)
* [x] Drop Web Widget into any Laravel application, including Laravel Nova, using `@botman` blade directive
* [x] Base class `ChatConversation` for building LLM-backed [Conversations](https://botman.io/2.0/conversations)
* [x] Extend Conversations to emulate Agents with [Tools](https://github.com/LLPhant/LLPhant?tab=readme-ov-file#tools) that execute PHP functions
* [x] Built-in Tool for crawling URLs which you can bootstrap into any `ChatConversation` with `$conversation->withCrawler()`
* [ ] Custom [Cache](https://botman.io/2.0/cache-drivers) driver for persisting Conversations between user sessions
* [ ] Enhanced Web Driver to provide for real-time message streaming using Laravel event system
* [ ] Discord Driver, to enable chat interactions in [Discord](https://discord.com/developers/docs/intro)
* [ ] Chat Completion Driver, to enable chat requests and responses to take the form of [OpenAI Chat Completions](https://platform.openai.com/docs/api-reference/chat/create)
* [ ] Examples of `ChatConversation` implementations, to help you start your journey
* [x] Example `BotManChatServerController` for setting up the server-side of `ChatConversation` instances
* [ ] Laravel Livewire Starter Kit bootstrapped with BotManChatSDK, perfect for deploying to [Laravel Cloud](https://cloud.laravel.com/)

## Quickstart

To be written:

* Clone the starter kit repo
* Add an environment variable
* Run it locally using `php artisan serve`

## Installation

Install this Laravel package via composer into an existing Laravel project:

```bash
composer require orchestratexr/botman-chat-sdk
```

Publish front-end assets and configuration

```bash
php artisan vendor:publish --provider="OrchestrateXR\BotManChatSDK\BotManChatServiceProvider"
```

Inject the chat client into your front-end using the `@botman` blade directive. For most Laravel applications,
this means adding `@botman` to your blade layout. 

```html
<html lang="en">
  <body>
    @slot
    
    {{!-- somewhere near the bottom --}}
    @blade
  </body>
</html>
```

In Laravel Nova applications, you can safely add `@botman` to your `meta.php` file. 

Create a web route for BotMan chat requests:

```php
<?php
// in your routes/web.php
use OrchestrateXR\BotManChatSDK\Http\Controllers\BotManChatServerController;
Route::post(BotManChat::config('chatServer'), [BotManChatServerController::class, 'listen']);
```

Lastly, if you are using all the defaults outlined above, you will need to create a
Laravel environment variable to hold your [OpenAI API Key](https://platform.openai.com/api-keys):

```bash
OPENAI_API_KEY=sk-proj-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```


## Configuration

You can configure the SDK by modifying your copy of `config/botman-chat-sdk.php`. It should
have been generated when you published the assets for this Laravel package. If it does not or
if you need to start over from scratch, just run this command:

```bash
php artisan vendor:publish --tag=botman-chat-sdk-config --force
```

## Customization

```php
// Usage description here
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email acollegeman@gmail.com instead of using the issue tracker.

## Credits

- [Aaron Collegeman](https://github.com/collegeman)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
