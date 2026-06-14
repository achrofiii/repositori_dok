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
        // @namalengkap
        Blade::directive('namalengkap', function ($expression) {
            return "<?php
            \$words = explode(' ', $expression);
            if (count(\$words) >= 2) {
                echo \$words[0] . ' ' . \$words[1] . implode('', array_map(fn(\$w) => ' ' . strtoupper(\$w[0]) . '.', array_slice(\$words, 2)));
            } else {
                echo $expression;
            }
        ?>";
        });

        // @avatarinitial
        Blade::directive('avatarinitial', function ($expression) {
            return "<?php
            \$words = explode(' ', $expression);
            echo strtoupper(count(\$words) >= 2 ? \$words[0][0] . \$words[1][0] : \$words[0][0]);
        ?>";
        });

        // @formatnama — huruf besar hanya di awal kata
        Blade::directive('formatnama', function ($expression) {
            return "<?php echo ucwords(strtolower($expression)); ?>";
        });

        Blade::directive('judul', function ($expression) {
            return "<?php echo Str::limit($expression, 50, '...'); ?>";
        });
    }
}
