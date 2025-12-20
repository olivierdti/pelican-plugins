<?php

namespace AllServerDefault;

use Filament\Contracts\Plugin;
use Filament\Panel;

class AllServerDefaultPlugin implements Plugin
{
    public function getId(): string
    {
        return 'allserverdefault';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}
}
