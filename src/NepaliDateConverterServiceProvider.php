<?php

namespace Proshore\NepaliDate;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class NepaliDateConverterServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerConfigs();
        $this->registerFacades();
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/nepaliDate.php' => config_path('nepali-date.php'),
        ], 'nepaliDate');
        $this->addCarbonMacro();
    }

    /**
     * @return void
     */
    private function registerFacades() : void
    {
        $this->app->bind(NepaliDateConverter::class, function ($app) {
            return NepaliDateConverter::make();
        });
    }

    /**
     * @return void
     */
    private function registerConfigs(): void
    {
        $configPath = __DIR__ . '/../config/nepali-date.php';
        $this->mergeConfigFrom($configPath, 'nepali-date');
    }

    /**
     * @return void
     */
    private function addCarbonMacro(): void
    {
        Carbon::macro('toBS', function () {
            return \Proshore\NepaliDate\Facades\NepaliDateConverter::toBs($this);
        });
        Carbon::macro('toBSDate', function () {
            return \Proshore\NepaliDate\Facades\NepaliDateConverter::toBsDate($this);
        });
        Carbon::macro('toBSFormattedDate', function () {
            return \Proshore\NepaliDate\Facades\NepaliDateConverter::toBsFormattedDate($this);
        });
    }

}
