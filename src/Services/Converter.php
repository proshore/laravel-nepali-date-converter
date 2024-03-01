<?php

namespace Proshore\NepaliDate\Services;

use Illuminate\Support\Carbon;
use Proshore\NepaliDate\Dto\NepaliDate;
use Proshore\NepaliDate\Validators\NepaliDateValidator;

class Converter
{
    /**
     * @var mixed
     */
    private mixed $calendarData;

    /**
     * @var NepaliDateValidator
     */
    private NepaliDateValidator $validator;
    /**
     * @var NepaliDate
     */
    private NepaliDate $date;

    /**
     * @param NepaliDateValidator $validator
     * @param NepaliDate $date
     */
    public function __construct(NepaliDateValidator $validator, NepaliDate $date)
    {
        $this->calendarData = config('nepali-date');
        $this->validator = $validator;
        $this->date = $date;
    }

    /**
     * @return Converter
     */
    public static function make() : Converter
    {
        $validator = new NepaliDateValidator();
        $date = NepaliDate::make();

        return new self($validator, $date);
    }

    /**
     * @param int $number
     * @return string
     */
    public function getNepaliNumber(int $number): string
    {
        if($number < 0) {
            throw new \Error("Number must be positive number");
        }

        $characters = str_split((string) $number);
        foreach($characters as $key => $character) {
            if(isset($this->calendarData['nepaliNumbers'][$character])) {
                $characters[$key] = $this->calendarData['nepaliNumbers'][$character];
            }
        }

        return implode('', $characters);
    }

    /**
     * @param int $bsMonth
     * @param int $yearDiff
     * @return float|int
     */
    private function getMonthDaysNumFormMinBsYear(int $bsMonth, int $yearDiff): float|int
    {
        $yearCount = 0;
        $monthDaysFromMinBsYear = 0;
        if($yearDiff === 0) {
            return 0;
        }
        $bsMonthData = $this->calendarData['extractedBsMonthData'][$bsMonth - 1];
        for($i = 0;$i < count($bsMonthData); $i++) {
            if($bsMonthData[$i] === 0) {
                continue;
            }
            $bsMonthUpperDaysIndex = $i % 2;
            if($yearDiff > ($yearCount + $bsMonthData[$i])) {
                $yearCount += $bsMonthData[$i];
                $monthDaysFromMinBsYear += $this->calendarData['bsMonthUpperDays'][$bsMonth - 1][$bsMonthUpperDaysIndex] * $bsMonthData[$i];
            } else {
                $monthDaysFromMinBsYear += $this->calendarData['bsMonthUpperDays'][$bsMonth - 1][$bsMonthUpperDaysIndex] * ($yearDiff - $yearCount);
                $yearCount = $yearDiff - $yearCount;

                break;
            }
        }

        return $monthDaysFromMinBsYear;
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @param int $bsDate
     * @return mixed
     */
    private function getTotalDaysNumFromMinBsYear(int $bsYear, int $bsMonth, int $bsDate): mixed
    {
        if($bsYear < $this->calendarData['minBsYear'] || $bsYear > $this->calendarData['maxBsYear']) {
            return null;
        }
        $daysNumFromMinBsYear = 0;
        $diffYears = $bsYear - $this->calendarData['minBsYear'];
        for($month = 1;$month <= 12; $month++) {
            if($month < $bsMonth) {
                $daysNumFromMinBsYear += $this->getMonthDaysNumFormMinBsYear($month, $diffYears + 1);
            } else {
                $daysNumFromMinBsYear += $this->getMonthDaysNumFormMinBsYear($month, $diffYears);
            }
        }
        if($bsYear > 2085 && $bsYear < 2088) {
            $daysNumFromMinBsYear += $bsDate - 2;
        } elseif($bsYear === 2085 && $bsMonth > 5) {
            $daysNumFromMinBsYear += $bsDate - 2;
        } elseif($bsYear > 2088) {
            $daysNumFromMinBsYear += $bsDate - 4;
        } elseif($bsDate === 2088 && $bsMonth > 5) {
            $daysNumFromMinBsYear += $bsDate - 4;
        } else {
            $daysNumFromMinBsYear += $bsDate;
        }

        return $daysNumFromMinBsYear;
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @return int|mixed|null
     */
    private function getBsMonthDays(int $bsYear, int $bsMonth): mixed
    {
        $yearCount = 0;
        $totalYears = $bsYear + 1 - $this->calendarData['minBsYear'];
        $bsMonthData = $this->calendarData['extractedBsMonthData'][$bsMonth - 1];
        for($i = 0;$i < count($bsMonthData); $i++) {
            if($bsMonthData[$i] === 0) {
                continue;
            }
            $bsMonthUpperDaysIndex = $i % 2;
            $yearCount += $bsMonthData[$i];
            if($totalYears <= $yearCount) {
                if(($bsYear === 2085 && $bsMonth === 5) || ($bsYear === 2088 && $bsMonth === 5)) {
                    return $this->calendarData['bsMonthUpperDays'][$bsMonth - 1][$bsMonthUpperDaysIndex] - 2;
                } else {
                    return $this->calendarData['bsMonthUpperDays'][$bsMonth - 1][$bsMonthUpperDaysIndex];
                }
            }
        }

        return null;
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @param int $bsDay
     * @return array<string,int>|null
     */
    public function getAdDateByBsDate(int $bsYear, int $bsMonth, int $bsDay): array|null
    {
        $validated = $this->validator->validateBs($bsYear, $bsMonth, $bsDay);
        if(! $validated) {
            return null;
        }
        $daysNumFromMinBsYear = $this->getTotalDaysNumFromMinBsYear($bsYear, $bsMonth, $bsDay);
        $adDate = [
            $this->calendarData['minAdDateEqBsDate']['ad']['year'],
            $this->calendarData['minAdDateEqBsDate']['ad']['month'],
            $this->calendarData['minAdDateEqBsDate']['ad']['date'] - 1,
        ];
        $adDate = implode('-', $adDate);
        $adDate = Carbon::parse($adDate)->addDays($daysNumFromMinBsYear);

        return [
            'year' => $adDate->year,
            'month' => $adDate->month,
            'date' => $adDate->day,
        ];
    }

    /**
     * @param int $adYear
     * @param int $adMonth
     * @param int $adDate
     * @return array<string,int>|null
     */
    public function getBsDateByAdDate(int $adYear, int $adMonth, int $adDate) : array|null
    {
        $validated = $this->validator->validateAd($adYear, $adMonth, $adDate);
        if(! $validated) {
            return null;
        }

        $bsYear = $adYear + 57;
        $bsMonth = ($adMonth + 9) % 12;
        $bsMonth = $bsMonth === 0 ? 12 : $bsMonth;
        $bsDate = 1;
        if($adMonth < 4) {
            $bsYear--;
        } elseif($adMonth === 4) {
            $bsYearFirstAdDate = $this->getAdDateByBsDate($bsYear, 1, 1);
            if(! $bsYearFirstAdDate) {
                return null;
            }
            if($adDate < $bsYearFirstAdDate['date']) {
                $bsYear--;
            }
        }
        $bsMonthFirstAdDate = $this->getAdDateByBsDate($bsYear, $bsMonth, 1);
        if(! $bsMonthFirstAdDate) {
            return  null;
        }
        if ($adDate >= 1 && $adDate < $bsMonthFirstAdDate['date']) {
            $bsMonth = $bsMonth !== 1 ? $bsMonth - 1 : 12;
            $bsMonthDays = $this->getBsMonthDays($bsYear, $bsMonth);
            $bsDate = $bsMonthDays - ($bsMonthFirstAdDate['date'] - $adDate) + 1;
        } else {
            $bsDate = $adDate - $bsMonthFirstAdDate['date'] + 1;
        }


        return [
            'year' => $bsYear,
            'month' => $bsMonth,
            'date' => $bsDate,
        ];
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @param int $bsDate
     * @return array<string,mixed>|null
     */
    private function bsDateFormat(int $bsYear, int $bsMonth, int $bsDate): array|null
    {
        $validated = $this->validator->validateBs($bsYear, $bsMonth, $bsDate);
        if(! $validated) {
            return null;
        }

        $eqAdDate = Carbon::parse(implode('-', $this->getAdDateByBsDate($bsYear, $bsMonth, $bsDate)));
        $weekDay = $eqAdDate->dayOfWeek + 1;

        return [
            'd' => $this->getNepaliNumber($bsDate),
            'y' => $this->getNepaliNumber($bsYear),
            'm' => $this->getNepaliNumber($bsMonth),
            'M' => $this->calendarData['bsMonths'][$bsMonth - 1],
            'D' => $this->calendarData['bsDays'][$weekDay - 1],
        ];
    }

    /**
     * @param int $bsYear
     * @param int $bsMonth
     * @param int $bsDate
     * @return array<string,mixed>|null
     */
    private function getBsMonthInfoByBsDate(int $bsYear, int $bsMonth, int $bsDate): array|null
    {
        $validated = $this->validator->validateBs($bsYear, $bsMonth, $bsDate);
        if(! $validated) {
            return null;
        }

        $bsMonthFirstAdDate = Carbon::parse(implode('-', $this->getAdDateByBsDate($bsYear, $bsMonth, 1)));
        $bsMonthDays = $this->getBsMonthDays($bsYear, $bsMonth);
        $bsDate = $bsDate > $bsMonthDays ? $bsMonthDays : $bsDate;
        $eqAdDate = Carbon::parse(implode('-', $this->getAdDateByBsDate($bsYear, $bsMonth, $bsDate)));
        $weekDay = $eqAdDate->dayOfWeek + 1;
        $formattedDate = $this->bsDateFormat($bsYear, $bsMonth, $bsDate);

        return [
            'bsYear' => $bsYear,
            'bsMonth' => $bsMonth,
            'bsDate' => $bsDate,
            'weekDay' => $weekDay,
            'formattedDate' => $formattedDate,
            'adDate' => $eqAdDate,
            'bsMonthFirstAdDate' => $bsMonthFirstAdDate,
            'bsMonthDays' => $bsMonthDays,
        ];
    }

    /**
     * @param \Carbon\Carbon $date
     * @return NepaliDate|null
     */
    public function getToBs(\Carbon\Carbon $date): ?NepaliDate
    {
        $parsed = $this->getBsDateByAdDate($date->year, $date->month, $date->day);
        if(! $parsed) {
            return null;
        }
        $converted = $this->getBsMonthInfoByBsDate($parsed['year'], $parsed['month'], $parsed['date']);
        if(! $converted) {
            return null;
        }

        return $this->date->get($converted, $this->calendarData['separator']);
    }
}
