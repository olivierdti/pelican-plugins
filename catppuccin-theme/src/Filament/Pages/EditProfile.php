<?php

namespace Olivier\CatppuccinTheme\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Olivier\CatppuccinTheme\CatppuccinThemePlugin;

trait HasCatppuccinThemeCustomization
{
    public function getCustomizationFormComponents(): array
    {
        return [
            Section::make('Catppuccin Theme')
                ->description('Customize your interface appearance')
                ->schema([
                    Select::make('catppuccin_flavor')
                        ->label('Theme Preference')
                        ->options(CatppuccinThemePlugin::getThemeOptions())
                        ->default(function () {
                            $user = auth()->user();
                            return CatppuccinThemePlugin::getUserPreference($user->id) 
                                ?? config('catppuccin-theme.flavor', 'mocha');
                        })
                        ->live()
                        ->afterStateUpdated(function ($state) {
                            $user = auth()->user();
                            if ($user && $state) {
                                CatppuccinThemePlugin::saveUserPreference($user->id, $state);
                                
                                \Filament\Notifications\Notification::make()
                                    ->title('Theme updated')
                                    ->body('Your theme has been saved. Reload the page to apply it.')
                                    ->success()
                                    ->send();
                            }
                        })
                        ->helperText('Select your preferred Catppuccin theme. The page will need to be reloaded to see the changes.'),
                ]),
        ];
    }
}
