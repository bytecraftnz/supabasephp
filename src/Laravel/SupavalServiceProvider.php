<?php

namespace Bytecraftnz\SupabasePhp\Laravel;

use Illuminate\Support\Facades\Auth;

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
            __DIR__.'/../config/supaval.php' => $this->app->configPath('supaval.php'),
        ], 'supaval');

        $this->registerClass();

        Auth::provider('supaval', function ($app, array $_) {
            return $app->make(SupavalUserProvider::class);
        }); 

    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/supaval.php', 'supaval'
        );

    }



    private function registerClass()
    {

        $this->app->singleton(\Bytecraftnz\SupabasePhp\Contracts\AdminClient::class, function ($app) {
            $config = $app->make('config')->get('supaval');

            return new \Bytecraftnz\SupabasePhp\AdminClient(
                $config['supabase_url'],
                $config['api_key'],
                $config['service_role_key']
            );
        });

        $this->app->singleton(\Bytecraftnz\SupabasePhp\Contracts\AuthClient::class, function ($app) {
            $config = $app->make('config')->get('supaval');

            return new \Bytecraftnz\SupabasePhp\AuthClient(
                $config['supabase_url'],
                $config['api_key']
            );
        });


    }

}