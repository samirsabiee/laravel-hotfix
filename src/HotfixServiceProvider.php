<?php

namespace SamirSabiee\Hotfix;

use Illuminate\Support\ServiceProvider;

class HotfixServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/hotfix.php', 'hotfix');
    }

    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();
        $this->loadMigrationsFrom(__DIR__.'/../database/2023_01_11_1673400407_create_hotfixes_table.php');
    }

    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/hotfix.php' => config_path('hotfix.php'),
            ]);
        }
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\HotfixCommand::class,
                Commands\HotfixLogsCommand::class,
                Commands\HotfixLsCommand::class,
                Commands\HotfixMakeCommand::class,
                Commands\HotfixPruneCommand::class,
                Commands\HotfixRetryCommand::class,
                Commands\HotfixRunCommand::class,
                Commands\HotfixStatusCommand::class,
            ]);
        }
    }
}
