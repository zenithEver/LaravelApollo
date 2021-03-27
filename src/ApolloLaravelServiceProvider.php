<?php


namespace Sunaloe\ApolloLaravel;


use Illuminate\Support\ServiceProvider;

class ApolloLaravelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->configure();
        $this->registerServices();
        $this->registerCommands();
    }

    protected function registerServices()
    {
        $this->app->singleton('apollo.service', function ($app) {
            return new ApolloService();
        });

        $this->app->singleton('apollo.variable', function () {
            return new ApolloVariable();
        });
    }

    protected function configure()
    {
        $this->publishes([
            __DIR__.'/config/apollo.php' => config_path('apollo.php'),
        ]);
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([Console\WorkCommand::class]);
            return;
        }
    }
}
