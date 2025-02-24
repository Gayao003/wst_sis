<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('getCurrentSemester', function () {
            return "<?php
                \$month = date('n');
                if (\$month >= 6 && \$month <= 10) {
                    echo 'First';
                } elseif (\$month >= 11 || \$month <= 3) {
                    echo 'Second';
                } else {
                    echo 'Summer';
                }
            ?>";
        });
    }
}
