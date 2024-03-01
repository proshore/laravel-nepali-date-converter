<?php

namespace Proshore\NepaliDate\Validators;

use Illuminate\Support\Facades\Log;

class NepaliDateValidator
{
    /**
     * @var mixed
     */
    private mixed $calendarData;


    public function __construct()
    {
        $this->calendarData = config("nepali-date");
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @param int $bsDay
     * @return bool
     */
    public function validateBs(int $bsYear, int $bsMonth, int $bsDay): bool
    {
        return $this->validateBsYear($bsYear) &&
            $this->validateBsMonth($bsMonth) &&
            $this->validateBsDate($bsDay);

    }

    /**
     * @param int $adYear
     * @param int $adMonth
     * @param int $adDate
     * @return bool
     */
    public function validateAd(int $adYear, int $adMonth, int $adDate): bool
    {
        return $this->validateAdYear($adYear) &&
        $this->validateAdMonth($adMonth) &&
        $this->validateAdDate($adDate);
    }

    /**
     * @param int $bsYear
     * @return bool
     */
    public function validateBsYear(int $bsYear): bool
    {
        if(! $bsYear) {
            Log::error("Invalid parameter bsYear value");

            return false;
        }
        if($bsYear < $this->calendarData['minBsYear'] || $bsYear > $this->calendarData['maxBsYear']) {
            Log::error("Parameter BsYear value range error");

            return false;
        }

        return true;
    }

    /**
     * @param int $adYear
     * @return bool
     */
    public function validateAdYear(int $adYear): bool
    {
        if(! $adYear) {
            Log::error("Invalid parameter adYear value");

            return false;
        }
        if($adYear < ($this->calendarData['minBsYear'] - 57) || $adYear > $this->calendarData['maxBsYear'] - 57) {
            Log::error("Parameter BsYear value range error");

            return false;
        }

        return true;
    }

    /**
     * @param int $bsMonth
     * @return bool
     */
    public function validateBsMonth(int $bsMonth): bool
    {
        if(! $bsMonth) {
            Log::error("Invalid parameter bsMonth value");

            return false;
        }
        if($bsMonth < 1 || $bsMonth > 12) {
            Log::error("Parameter bsMonth value should be in range 1 to 12");

            return false;
        }

        return true;
    }

    /**
     * @param int $bsDate
     * @return bool
     */
    public function validateBsDate(int $bsDate): bool
    {
        if(! $bsDate) {
            Log::error("Invalid parameter bsMonth value");

            return false;
        }
        if($bsDate < 1 || $bsDate > 32) {
            Log::error("Parameter bsMonth value should be in range 1 to 32");

            return false;
        }

        return true;
    }

    /**
     * @param int $adMonth
     * @return bool
     */
    public function validateAdMonth(int $adMonth): bool
    {
        if(! $adMonth) {
            Log::error("Invalid parameter bsMonth value");

            return false;
        }
        if($adMonth < 1 || $adMonth > 12) {
            Log::error("Parameter bsMonth value should be in range 1 to 12");

            return false;
        }

        return true;
    }

    /**
     * @param int $adDate
     * @return bool
     */
    public function validateAdDate(int $adDate): bool
    {
        if(! $adDate) {
            Log::error("Invalid parameter bsMonth value");

            return false;
        }
        if($adDate < 1 || $adDate > 32) {
            Log::error("Parameter bsMonth value should be in range 1 to 32");

            return false;
        }

        return true;
    }
}
