<?php

namespace AllServerDefault\Providers;

use App\Filament\App\Resources\Servers\Pages\ListServers;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AllServerDefaultServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $defaultTab = config('allserverdefault.default_tab', 'all');

        Livewire::listen('component.mount', function ($component) use ($defaultTab) {
            if ($component instanceof ListServers && !request()->has('tab')) {
                $component->activeTab = $defaultTab;
            }
        });

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            function () use ($defaultTab) {
                if (!request()->is('/') || request()->has('tab')) {
                    return '';
                }

                return Blade::render(<<<'HTML'
                    <script>
                        (function() {
                            if (window.location.pathname === '/' && !window.location.search.includes('tab=')) {
                                const url = '/?tab={{ $tab }}';
                                window.Livewire ? window.Livewire.navigate(url) : window.location.href = url;
                            }
                        })();
                    </script>
                HTML, ['tab' => $defaultTab]);
            }
        );
    }
}
