<?php

namespace Proshore\NepaliDate\Dto;

class NepaliDate
{
    /**
     * @var int
     */
    public int $year;

    /**
     * @var int
     */
    public int $month;

    /**
     * @var int
     */
    public int $day;

    /**
     * @var int
     */
    public int $weekDay;

    /**
     * @var FormattedDate
     */
    public FormattedDate $formattedDate;

    /**
     * @var int
     */
    public int $monthDays;

    /**
     * @var string
     */
    public string $date;

    /**
     * @param FormattedDate $formattedDate
     */
    public function __construct(FormattedDate $formattedDate)
    {
        $this->formattedDate = $formattedDate;
    }

    /**
     * @return NepaliDate
     */
    public static function make() : NepaliDate
    {
        $formattedDate = new FormattedDate();

        return new self($formattedDate);
    }


    /**
     * @param array<string,mixed> $converted
     * @param string $separator
     * @return $this
     */
    public function get(array $converted, string $separator): NepaliDate
    {
        $this->year = $converted['bsYear'];
        $this->month = $converted['bsMonth'];
        $this->day = $converted['bsDate'];
        $this->weekDay = $converted['weekDay'];
        $this->monthDays = $converted['bsMonthDays'];
        $this->date = "$this->year{$separator}$this->month{$separator}$this->day";
        $this->formattedDate = $this->formattedDate->get($converted['formattedDate']);

        return $this;
    }

    /**
     * @return string
     */
    public function getDate() : string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getFormattedDate() : string
    {
        return $this->formattedDate->date;
    }
}
