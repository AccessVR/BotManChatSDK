<?php

namespace OrchestrateXR\BotManChatSDK;

use OrchestrateXR\BotManChatSDK\Console\Commands\ChatCommand;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use OrchestrateXR\BotManChatSDK\Contracts\BotManChatConfigurator as BotManChatConfiguratorContract;

class BotManChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'botman-chat-sdk');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'botman-chat-sdk');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('botman-chat-sdk.php'),
            ], 'botman-chat-sdk-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/botman-chat-sdk'),
            ], 'botman-chat-sdk-views');

            $this->publishes([
                __DIR__.'/../public/build' => public_path('vendor/botman-chat-sdk'),
            ], 'botman-chat-sdk-assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/botman-chat-sdk'),
            ], 'botman-chat-sdk-lang');*/

            // Registering package commands.
            $this->commands([
                ChatCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'botman-chat-sdk');

        // Register the main class to use with the facade
        $this->app->singleton(BotManChatConfiguratorContract::class, fn () => new BotManChatConfigurator($this->app));

        Blade::directive('botman', function (string $expression) {
            return "<?php echo BotManChat::widget({$expression}); ?>";
        });
    }
}
