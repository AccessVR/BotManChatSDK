<?php

namespace OrchestrateXR\BotManChatSDK\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use OrchestrateXR\BotManChatSDK\Conversations\ChatConversation;

class BotManChatServerController
{

    public function listen(Request $request)
    {
        DriverManager::loadDriver(WebDriver::class);

        $botman = BotManFactory::create([], new LaravelCache());

        $botman->hears('(.*)', fn(BotMan $bot, $prompt) =>
            $bot->startConversation(ChatConversation::make($prompt)->withCrawler()));

        $botman->listen();
    }

}