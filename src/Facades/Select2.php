<?php

namespace Blockpc\Select2Wire\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Blockpc\Select2\Skeleton\SkeletonClass
 */
class Select2 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'select2';
    }
}
