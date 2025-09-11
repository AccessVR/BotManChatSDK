<?php

namespace OrchestrateXR\BotManChatSDK;

use Illuminate\Support\Facades\Facade;
use OrchestrateXR\BotManChatSDK\Contracts\BotManChatConfigurator as BotManChatConfiguratorContract;

/**
 * @method config($name = null, $value = null): mixed
 * @method echoChannel(): string
 *
 * @see \OrchestrateXR\BotManChatSDK\BotmanChatConfigurator
 */
class BotManChat extends Facade
{
    // semantics
    const ANYTHING = '(.*)';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BotManChatConfiguratorContract::class;
    }
}
