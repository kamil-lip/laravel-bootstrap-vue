<?php

namespace App\Providers;

use App\Validation\Veevalidate\RulesTranslatorInterface;
use App\Validation\Veevalidate\SimpleRulesTranslator;
use Illuminate\Support\ServiceProvider;

class RulesTranslatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SimpleRulesTranslator::class, function ($app) {
            return new SimpleRulesTranslator();
        });
    }
}
