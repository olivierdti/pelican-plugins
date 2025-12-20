<?php

namespace Olivier\CatppuccinTheme\Providers;

use Illuminate\Support\ServiceProvider;

class CatppuccinThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Service provider for Catppuccin Theme Plugin
        // All configuration is handled through plugin settings
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/catppuccin-theme.php',
            'catppuccin-theme'
        );
    }
}
