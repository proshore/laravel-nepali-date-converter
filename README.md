# Laravel Nepali Date Converter

This Laravel package provides functionality to convert dates from the Gregorian calendar (AD) to the Bikram Sambat calendar (BS) using the native Carbon library. It's especially useful for applications targeting Nepali users or systems where Bikram Sambat dates are relevant.

## Features

- Seamless conversion of dates from AD to BS and vice versa.
- Integration with Laravel's native Carbon library for efficient and accurate date manipulation.
- Simple to integrate into existing Laravel applications.

[![Tests](https://github.com/proshore/laravel-nepali-date-converter/actions/workflows/test.yml/badge.svg)](https://github.com/proshore/laravel-nepali-date-converter/actions/workflows/test.yml)
[![Laravel Nepali Date Converter Code Analysis](https://github.com/proshore/laravel-nepali-date-converter/actions/workflows/analyze.yml/badge.svg)](https://github.com/proshore/laravel-nepali-date-converter/actions/workflows/analyze.yml)

## Requirements

- PHP >= 8.0
- Carbon PHP Library




## Installation

### Composer
Install using composer

`composer require proshore/laravel-nepali-date-converter`

Publish your config file

`php artisan vendor:publish --tag=nepali-date`

## Usages
You can directly convert Carbon date to Nepali date using chain function in Carbon.

``Carbon\Carbon::now()->toBS();``

<img src="assets/example1.png" alt="To Bs Example">

Get Formatted date

``Carbon\Carbon::now()->toBSDate();``

``Carbon\Carbon::now()->toBSFormattedDate();``

<img src="assets/example2.png" alt="Formatted To Bs Example">

Using without carbon

``Proshore\NepaliDate\Facades\NepaliDateConverter::getBSbyAd(2024,03,01);``

``Proshore\NepaliDate\Facades\NepaliDateConverter::getADbyBS(2080,11,18);``

<img src="assets/example3.png" alt="Default converter">

Get Carbon date from Bs Date

``Proshore\NepaliDate\Facades\NepaliDateConverter::toAD(2080,11,18);``

<img src="assets/example4.png" alt="BS To Carbon Date">

## Contributers ✨
[<img style="border-radius: 50%; border: 2px solid black; width: 50px; height: 50px; object-fit: cover;" src="https://github.com/kundankarna1994.png" width="60px;"/><br /><sub>](https://github.com/kundankarna1994/)