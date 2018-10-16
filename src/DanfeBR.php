<?php

namespace Primehover\DanfeBR;

use Illuminate\Support\Facades\Facade;

class DanfeBR extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return API::class; }

}