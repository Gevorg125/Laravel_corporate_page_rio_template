<?php

namespace Corp\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //@set($i, 10)// haytararelu dzev@,, popoxakanin arjeq talu hamar functia
        Blade::directive('set', function($exp){
            list($name, $val) = explode(',', $exp);
            return "<?php $name = $val ?>";
        });
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
