<?php

namespace Pinaadrian\Cybersource;

use Illuminate\Support\ServiceProvider;

class CybersourceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
          __DIR__.'/conf/cybersource.php' => config_path('cybersource.php'),
      ], 'cybersource');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
