<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // models
        $this->configureModels();
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        /*
         * models should prevent lazy loading
         * stops silently discarding attributes, and accessing missing attributes
         * */
        //Model::shouldBeStrict();

        /*
         * removes annoying mass assignable restrictions
         * */
        Model::unguard();
    }
}
