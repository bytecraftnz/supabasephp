<?php

namespace Bytecraftnz\SupabasePhp\Laravel;

use Bytecraftnz\SupabasePhp\Contracts\AdminClient;

class SupavalServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/supabase.php' => $this->app->configPath('supabase.php'),
        ], 'supaval');

        $this->registerClass();
    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/supaval.php', 'supaval'
        );

    }



    private function registerClass()
    {
        $this->app->singleton(AdminClient::class, function ($app) {
            $config = $app->make('config')->get('supaval');

            return new \Bytecraftnz\SupabasePhp\AdminClient(
                $config['url'],
                $config['key'],
                $config['service_key']
            );
        });

        $this->app->singleton(\Bytecraftnz\SupabasePhp\Contracts\AuthClient::class, function ($app) {
            $config = $app->make('config')->get('supaval');

            return new \Bytecraftnz\SupabasePhp\AuthClient(
                $config['url'],
                $config['key']
            );
        });

        
    }

}