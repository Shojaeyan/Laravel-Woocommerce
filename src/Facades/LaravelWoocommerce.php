<?php

namespace GuideMaster\LaravelWoocommerce\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelWoocommerce extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-woocommerce';
    }
}
