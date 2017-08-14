<?php

use Illuminate\Support\Facades\Facade;

class Timezones extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Snscripts\Timezones\Timezones';
    }
}
