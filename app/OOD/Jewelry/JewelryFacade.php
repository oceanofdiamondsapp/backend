<?php

namespace OOD\Jewelry;

use Illuminate\Support\Facades\Facade;

class JewelryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Jewelry';
    }
}
