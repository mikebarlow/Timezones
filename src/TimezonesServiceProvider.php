<?php

namespace Snscripts\Timezones;

use Illiminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TimezonesServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Snscripts\Timezones\Timezones',
            function ($app) {
                return new \Snscripts\Timezones\Timezones;
            }
        );
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive(
            'displayDate',
            function ($expression) {
                list($DateTime, $Timezone, $format) = explode(',', $expression);

                return  "<?php echo \Timezone::convertToLocal($DateTime, $Timezone, $format); ?>";
            }
        );
    }
}
