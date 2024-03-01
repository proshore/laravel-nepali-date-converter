<?php

use Carbon\Carbon;
use Proshore\NepaliDate\Dto\FormattedDate;
use Proshore\NepaliDate\Dto\NepaliDate;

test('can_parse_valid_date', function () {
    $nepaliDate = Carbon::now()->toBs();
    expect($nepaliDate)->toBeInstanceOf(NepaliDate::class);
    expect($nepaliDate->formattedDate)->toBeInstanceOf(FormattedDate::class);
});


test('can_parse_valid_bs_date', function () {
    $nepaliDate = Carbon::now()->toBsDate();
    expect($nepaliDate)->toBeString();
});

test('can_parse_valid_bs_formatted_date', function () {
    $nepaliDate = Carbon::now()->toBsFormattedDate();
    expect($nepaliDate)->toBeString();
});

test("cannot_get_invalid_date", function () {
    $nepaliDate = Carbon::now()->addYears(100)->toBs();
    expect($nepaliDate)->toBeNull();
});
