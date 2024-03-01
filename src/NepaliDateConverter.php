<?php

namespace Proshore\NepaliDate;

use Carbon\Carbon;
use Proshore\NepaliDate\Dto\NepaliDate;
use Proshore\NepaliDate\Services\Converter;

class NepaliDateConverter
{
    /**
     * @var Converter
     */
    private Converter $converter;

    /**
     * @param Converter $converter
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @return NepaliDateConverter
     */
    public static function make(): NepaliDateConverter
    {
        $converter = Converter::make();

        return new self($converter);
    }

    /**
     * @param Carbon $date
     * @return NepaliDate|null
     */
    public function toBs(Carbon $date): ?NepaliDate
    {
        return $this->converter->getToBs($date);
    }

    /**
     * @param Carbon $date
     * @return string|null
     */
    public function toBsDate(Carbon $date): ?string
    {
        return $this->converter->getToBs($date)?->getDate();
    }

    /**
     * @param Carbon $date
     * @return string|null
     */
    public function toBsFormattedDate(Carbon $date): ?string
    {
        return $this->converter->getToBs($date)?->getFormattedDate();
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @param int $bsDay
     * @return array<string,int>|null
     */
    public function getAdDateByBsDate(int $bsYear, int $bsMonth, int $bsDay): array|null
    {
        return $this->converter->getAdDateByBsDate($bsYear, $bsMonth, $bsDay);
    }

    /**
     * @param int $adYear
     * @param int $adMonth
     * @param int $adDate
     * @return array<string,int>|null
     */
    public function getBsDateByAdDate(int $adYear, int $adMonth, int $adDate) : array|null
    {
        return $this->converter->getBsDateByAdDate($adYear, $adMonth, $adDate);
    }

}
