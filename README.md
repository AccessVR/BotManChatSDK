# An SDK for building AI-backed Chat Bots with BotMan and Laravel

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
* [ ] Example implementations of `ChatConversation` to help you get started
* [ ] Enhanced Web Driver to provide for real-time message streaming

## Installation

Install this Laravel package via composer:

```bash
composer require orchestratexr/botman-chat-sdk
```

## Usage

```php
// Usage description here
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email acollegeman@gmail.com instead of using the issue tracker.

## Credits

-   [Aaron Collegeman](https://github.com/collegeman)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
