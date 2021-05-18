<?php

namespace EgeaTech\LaravelModels\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelModels extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-models';
    }
}
