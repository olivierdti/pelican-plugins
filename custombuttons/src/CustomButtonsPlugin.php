<?php

namespace Olivier\CustomButtons;

use App\Contracts\Plugins\HasPluginSettings;
use Filament\Contracts\Plugin;
use Filament\Notifications\Notification;
use Filament\Panel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
            if (!Schema::hasTable('custom_buttons')) {
                return [];
            }
            
            return CustomButton::orderBy('sort')
                ->get()
                ->map(fn ($button) => [
                    'text' => $button->text,
                    'url' => $button->url,
                    'icon' => $button->icon,
                    'color' => $button->color,
                    'new_tab' => $button->new_tab,
                    'sort' => $button->sort,
                    'is_active' => $button->is_active,
                ])
                ->toArray();
        } catch (\Exception $e) {
            Log::error('CustomButtonsPlugin loadButtons error: ' . $e->getMessage());
            return [];
        }
    }

    protected function loadSidebarItems(): array
    {
        try {
            if (!Schema::hasTable('custom_sidebar_items')) {
                return [];
            }
            
            return CustomSidebarItem::orderBy('sort')
                ->get()
                ->map(fn ($item) => [
                    'label' => $item->label,
                    'url' => $item->url,
                    'icon' => $item->icon,
                    'sort' => $item->sort,
                    'new_tab' => $item->new_tab,
                    'is_active' => $item->is_active,
                ])
                ->toArray();
        } catch (\Exception $e) {
            Log::error('CustomButtonsPlugin loadSidebarItems error: ' . $e->getMessage());
            return [];
        }
    }

    public function saveSettings(array $data): void
    {
        try {
            if (!Schema::hasTable('custom_buttons')) {
                throw new \Exception('Table custom_buttons does not exist. Please run migrations.');
            }
            
            if (!Schema::hasTable('custom_sidebar_items')) {
                throw new \Exception('Table custom_sidebar_items does not exist. Please run migrations.');
            }

            CustomButton::truncate();
            CustomSidebarItem::truncate();

            foreach ($data['buttons'] ?? [] as $button) {
                $buttonData = array_intersect_key($button, array_flip([
                    'text', 'url', 'icon', 'color', 'new_tab', 'sort', 'is_active'
                ]));
                
                if (empty($buttonData['text']) || empty($buttonData['url'])) {
                    continue;
                }
                
                if (isset($buttonData['new_tab'])) {
                    $buttonData['new_tab'] = (bool) $buttonData['new_tab'];
                }
                if (isset($buttonData['is_active'])) {
                    $buttonData['is_active'] = (bool) $buttonData['is_active'];
                }
                
                $buttonData['color'] = $buttonData['color'] ?? 'primary';
                $buttonData['sort'] = $buttonData['sort'] ?? 0;
                $buttonData['new_tab'] = $buttonData['new_tab'] ?? true;
                $buttonData['is_active'] = $buttonData['is_active'] ?? true;
                
                CustomButton::create($buttonData);
            }

            foreach ($data['sidebar_items'] ?? [] as $item) {
                $itemData = array_intersect_key($item, array_flip([
                    'label', 'url', 'icon', 'sort', 'new_tab', 'is_active'
                ]));
                
                if (empty($itemData['label']) || empty($itemData['url'])) {
                    continue;
                }
                
                if (isset($itemData['new_tab'])) {
                    $itemData['new_tab'] = (bool) $itemData['new_tab'];
                }
                if (isset($itemData['is_active'])) {
                    $itemData['is_active'] = (bool) $itemData['is_active'];
                }
                
                $itemData['sort'] = $itemData['sort'] ?? 50;
                $itemData['new_tab'] = $itemData['new_tab'] ?? false;
                $itemData['is_active'] = $itemData['is_active'] ?? true;
                
                CustomSidebarItem::create($itemData);
            }
            
            Notification::make()
                ->title('Settings saved')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error saving settings')
                ->body($e->getMessage())
                ->danger()
                ->send();
            
            Log::error('CustomButtonsPlugin saveSettings error: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data
            ]);
        }
    }

    public static function getButtons()
    {
        return CustomButton::active()->get();
    }
}
