<?php

namespace App\Providers;

use App\Validation\Veevalidate\{
    SimpleRulesTranslator, RulesTranslatorInterface
};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class RulesTranslatorProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(SimpleRulesTranslator::class);
    }
}