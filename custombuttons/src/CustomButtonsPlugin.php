<?php

namespace Olivier\CustomButtons;

use App\Contracts\Plugins\HasPluginSettings;
use Filament\Contracts\Plugin;
use Filament\Notifications\Notification;
use Filament\Panel;
use Olivier\CustomButtons\Models\CustomButton;
use Olivier\CustomButtons\Models\CustomSidebarItem;

class CustomButtonsPlugin implements HasPluginSettings, Plugin
{

    public function getId(): string
    {
        return 'custombuttons';
    }

    public function register(Panel $panel): void
    {
    }

    public function boot(Panel $panel): void
    {
        if ($panel->getId() !== 'server') {
            return;
        }

        try {
            $sidebarItems = CustomSidebarItem::active()->get();
            
            if ($sidebarItems->isNotEmpty()) {
                $items = [];
                
                foreach ($sidebarItems as $item) {
                    $navItem = \Filament\Navigation\NavigationItem::make($item->label)
                        ->url($item->url)
                        ->sort($item->sort);

                    if (!empty($item->icon)) {
                        $navItem->icon($item->icon);
                    }

                    if ($item->new_tab) {
                        $navItem->openUrlInNewTab();
                    }

                    $items[] = $navItem;
                }
                
                $panel->navigationItems($items);
            }
        } catch (\Exception $e) {
        }
    }

    public function getSettingsForm(): array
    {
        return [
            \Filament\Forms\Components\Repeater::make('buttons')
                ->label('Console Buttons')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('text')
                        ->label('Button Text')
                        ->required()
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('url')
                        ->label('Button URL')
                        ->required()
                        ->url()
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('icon')
                        ->label('Icon (Tabler icon name)')
                        ->placeholder('tabler-link')
                        ->helperText('See https://tabler.io/icons')
                        ->maxLength(255),
                    \Filament\Forms\Components\Select::make('color')
                        ->label('Button Color')
                        ->options([
                            'primary' => 'Primary',
                            'success' => 'Success',
                            'warning' => 'Warning',
                            'danger' => 'Danger',
                            'info' => 'Info',
                            'gray' => 'Gray',
                        ])
                        ->default('primary'),
                    \Filament\Forms\Components\TextInput::make('sort')
                        ->label('Sort Order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first'),
                    \Filament\Forms\Components\Toggle::make('new_tab')
                        ->label('Open in new tab')
                        ->default(true)
                        ->inline(false),
                    \Filament\Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->inline(false),
                ])
                ->collapsible()
                ->defaultItems(0)
                ->addActionLabel('Add Button')
                ->columns(2)
                ->default(fn () => $this->loadButtons()),
            \Filament\Forms\Components\Repeater::make('sidebar_items')
                ->label('Sidebar Navigation Items')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('label')
                        ->label('Label')
                        ->required()
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('url')
                        ->label('URL')
                        ->required()
                        ->url()
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('icon')
                        ->label('Icon (Tabler icon name)')
                        ->placeholder('tabler-link')
                        ->helperText('See https://tabler.io/icons')
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('sort')
                        ->label('Sort Order')
                        ->numeric()
                        ->default(50)
                        ->helperText('Lower numbers appear first'),
                    \Filament\Forms\Components\Toggle::make('new_tab')
                        ->label('Open in new tab')
                        ->default(false)
                        ->inline(false),
                    \Filament\Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->inline(false),
                ])
                ->collapsible()
                ->defaultItems(0)
                ->addActionLabel('Add Navigation Item')
                ->columns(2)
                ->default(fn () => $this->loadSidebarItems()),
        ];
    }

    protected function loadButtons(): array
    {
        try {
            return CustomButton::orderBy('sort')->get()->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function loadSidebarItems(): array
    {
        try {
            return CustomSidebarItem::orderBy('sort')->get()->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function saveSettings(array $data): void
    {
        CustomButton::truncate();
        CustomSidebarItem::truncate();

        foreach ($data['buttons'] ?? [] as $button) {
            CustomButton::create($button);
        }

        foreach ($data['sidebar_items'] ?? [] as $item) {
            CustomSidebarItem::create($item);
        }
        
        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }

    public static function getButtons()
    {
        return CustomButton::active()->get();
    }
}
