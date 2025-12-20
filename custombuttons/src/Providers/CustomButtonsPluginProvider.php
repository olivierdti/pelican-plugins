<?php

namespace Olivier\CustomButtons\Providers;

use App\Enums\HeaderActionPosition;
use App\Filament\Server\Pages\Console;
use Illuminate\Support\ServiceProvider;
use Olivier\CustomButtons\Models\CustomButton;

class CustomButtonsPluginProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        try {
            // Register custom buttons from database
            $buttons = CustomButton::active()->get();
            
            foreach ($buttons as $button) {
                Console::registerCustomHeaderActions(
                    HeaderActionPosition::After,
                    \Olivier\CustomButtons\Filament\Components\Actions\CustomButtonAction::make("custom_button_{$button->id}")
                        ->buttonData([
                            'text' => $button->text,
                            'url' => $button->url,
                            'icon' => $button->icon,
                            'color' => $button->color,
                            'new_tab' => $button->new_tab,
                        ])
                );
            }
        } catch (\Exception $e) {
        }
    }
}
