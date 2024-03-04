<?php

namespace Proshore\NepaliDate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static toBs()
 * @method static toAd()
 * @method static toBsDate()
 * @method static toBsFormattedDate()
 * @method static getAdDateByBsDate()
 * @method static getBsDateByAdDate()
 * @see \Proshore\NepaliDate\NepaliDateConverter
 */
class NepaliDateConverter extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Proshore\NepaliDate\NepaliDateConverter::class;
    }
}
