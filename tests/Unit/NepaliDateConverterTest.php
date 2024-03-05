<?php

use Carbon\Carbon;
use Proshore\NepaliDate\Dto\FormattedDate;
use Proshore\NepaliDate\Dto\NepaliDate;

test('can_parse_valid_date', function () {
    $nepaliDate = Carbon::now()->toBS();
    expect($nepaliDate)->toBeInstanceOf(NepaliDate::class);
    expect($nepaliDate->formattedDate)->toBeInstanceOf(FormattedDate::class);
});


test('can_parse_valid_bs_date', function () {
    $nepaliDate = Carbon::now()->toBSDate();
    expect($nepaliDate)->toBeString();
});

test('can_parse_valid_bs_formatted_date', function () {
    $nepaliDate = Carbon::now()->toBSFormattedDate();
    expect($nepaliDate)->toBeString();
});

test("cannot_get_invalid_date", function () {
    $nepaliDate = Carbon::now()->addYears(100)->toBS();
    expect($nepaliDate)->toBeNull();
});

test("can_get_ad_carbon_date_from_nepali_date", function () {
    $date = \Proshore\NepaliDate\Facades\NepaliDateConverter::toAD(2080, 01, 06);
    expect($date)->toBeInstanceOf(Carbon::class);
});

test('can_get_ad_date_by_bs_date', function () {
    $date = \Proshore\NepaliDate\Facades\NepaliDateConverter::getADbyBS(2080, 01, 06);
    expect($date)->toBeArray();
});

test('can_get_bs_date_by_ad_date', function () {
    $date = \Proshore\NepaliDate\Facades\NepaliDateConverter::getBSbyAD(2024, 03, 01);
    expect($date)->toBeArray();
});
