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
        Livewire::listen('component.hydrate', function ($component) {
            if ($component instanceof ListServers) {
                $defaultTab = config('allserverdefault.default_tab', 'all');
                
                if (!request()->has('tab')) {
                    $component->activeTab = $defaultTab;
                }
            }
        });

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn () => Blade::render(<<<'HTML'
                <script>
                    (function() {
                        const defaultTab = '{{ config("allserverdefault.default_tab", "all") }}';
                        
                        document.addEventListener('click', function(e) {
                            const link = e.target.closest('a[href]');
                            if (!link) return;
                            
                            const href = link.getAttribute('href');
                            if (!href) return;
                            
                            if (href === '/' || href === window.location.origin + '/' || href.match(/^\/$/) || 
                                (href.includes(window.location.origin) && href.endsWith('/'))) {
                                e.preventDefault();
                                
                                // Naviguer vers /?tab=all
                                if (link.hasAttribute('wire:navigate')) {
                                    Livewire.navigate('/?tab=' + defaultTab);
                                } else {
                                    window.location.href = '/?tab=' + defaultTab;
                                }
                            }
                        }, true);
                        
                        if (window.location.pathname === '/' && !window.location.search.includes('tab=')) {
                            window.history.replaceState({}, '', '/?tab=' + defaultTab);
                            window.location.reload();
                        }
                    })();
                </script>
            HTML)
        );
    }
}
