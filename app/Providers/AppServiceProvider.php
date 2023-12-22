<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            $vite = app()->make(Vite::class);

            $cssPath = public_path('resources/css/filament.css'); // Ensure correct path

            if (File::exists($cssPath)) {
                $assetUrl = URL::asset('resources/css/filament.css'); // Get the asset URL
                Filament::registerViteTheme(
                    $vite->asset($assetUrl)
                );
            } else {
                // Handle case when the CSS file doesn't exist
                // This can be logging an error or handling it in another appropriate way
                Log::error('Filament CSS file not found: resources/css/filament.css');
            }
        });
    }
}
