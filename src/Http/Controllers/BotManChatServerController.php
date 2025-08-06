<?php

namespace OrchestrateXR\BotManChatSDK\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use LLPhant\Chat\Enums\OpenAIChatModel;
use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;
use OrchestrateXR\BotManChatSDK\Conversations\ChatConversation;

class BotManChatServerController
{

    public function listen(Request $request)
    {
        DriverManager::loadDriver(WebDriver::class);

        $botman = BotManFactory::create([], new LaravelCache());

        $botman->hears('(.*)', function(BotMan $bot, $prompt) {
            $config = new OpenAIConfig();
            $config->apiKey = env('OPENAI_API_KEY');
            $config->model = OpenAIChatModel::Gpt4Omni->value;

            $bot->startConversation(
                (new ChatConversation())
                    ->system('You are a helpful assistant. You strive for brevity and clarity.')
                    ->chat(new OpenAIChat($config))
            );
        });

        $botman->listen();

    }

}