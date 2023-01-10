<?php

namespace SamirSabiee\Hotfix;

use Illuminate\Support\ServiceProvider;

class HotfixServiceProvider extends ServiceProvider
{

    public function register()
    {
    }

    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();
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
                Commands\HotfixMakeCommand::class,
            ]);
        }
    }
}
