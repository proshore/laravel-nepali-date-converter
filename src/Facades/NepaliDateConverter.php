<?php

namespace Proshore\NepaliDate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static toBS()
 * @method static toAD()
 * @method static toBSDate()
 * @method static toBSFormattedDate()
 * @method static getADbyBS()
 * @method static getBSbyAD()
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
