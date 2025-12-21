<?php

namespace Olivier\EnhancedServerSorter;

use App\Enums\HeaderActionPosition;
use App\Filament\App\Resources\Servers\Pages\ListServers;
use Filament\Actions\Action;
use Filament\Contracts\Plugin;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Panel;
use Illuminate\Support\Collection;
use Olivier\EnhancedServerSorter\Models\ServerFolder;
use Olivier\EnhancedServerSorter\Models\ServerFolderAssignment;
use Olivier\EnhancedServerSorter\Providers\EnhancedServerSorterServiceProvider;

class EnhancedServerSorterPlugin implements Plugin
{
    private static bool $providerRegistered = false;

    public function getId(): string
    {
        return 'enhancedserversorter';
    }

    public function register(Panel $panel): void
    {
        if (!self::$providerRegistered) {
            app()->register(EnhancedServerSorterServiceProvider::class);
            self::$providerRegistered = true;
        }

        if ($panel->getId() !== 'app') {
            return;
        }

        ListServers::registerCustomHeaderActions(
            HeaderActionPosition::After,
            $this->makeManageFoldersAction()
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    private function makeManageFoldersAction(): Action
    {
        return Action::make('manageFolders')
            ->label('Manage folders')
            ->icon('tabler-folders')
            ->modalWidth('2xl')
            ->modalSubmitActionLabel('Save')
            ->visible(fn () => user() !== null)
            ->form(function () {
                $servers = user()?->accessibleServers()?->pluck('name', 'id') ?? collect();

                return [
                    Repeater::make('folders')
                        ->label('Folders')
                        ->default(fn () => $this->loadFolders())
                        ->live()
                        ->schema([
                            Hidden::make('id'),
                            TextInput::make('name')
                                ->label('Name')
                                ->required()
                                ->maxLength(255),
                            Select::make('server_ids')
                                ->label('Servers')
                                ->multiple()
                                ->options($servers)
                                ->searchable()
                                ->preload()
                                ->live()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                        ])
                        ->collapsed()
                        ->reorderableWithButtons()
                        ->addActionLabel('Add folder'),
                ];
            })
            ->action(function (array $data) {
                $user = user();

                if (!$user) {
                    return;
                }

                $folders = collect($data['folders'] ?? []);
                
                $allServerIds = [];
                $duplicates = [];
                
                foreach ($folders as $folder) {
                    $serverIds = $folder['server_ids'] ?? [];
                    foreach ($serverIds as $serverId) {
                        if (in_array($serverId, $allServerIds)) {
                            $duplicates[] = $serverId;
                        }
                        $allServerIds[] = $serverId;
                    }
                }
                
                if (!empty($duplicates)) {
                    $serverNames = user()?->accessibleServers()
                        ->whereIn('servers.id', array_unique($duplicates))
                        ->pluck('name')
                        ->join(', ');
                    
                    Notification::make()
                        ->title('Duplicate servers detected')
                        ->body("The following servers are assigned to multiple folders: {$serverNames}")
                        ->danger()
                        ->send();
                    
                    return;
                }

                $this->persistFolders($folders, $user->id);

                Notification::make()
                    ->title('Folders updated')
                    ->success()
                    ->send();
            });
    }

    private function loadFolders(): array
    {
        $user = user();

        if (!$user) {
            return [];
        }

        return ServerFolder::query()
            ->with('assignments')
            ->where('user_id', $user->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (ServerFolder $folder) => [
                'id' => $folder->id,
                'name' => $folder->name,
                'server_ids' => $folder->assignments->pluck('server_id')->all(),
            ])
            ->all();
    }

    private function persistFolders(Collection $folders, int $userId): void
    {
        $accessibleServerIds = user()?->accessibleServers()?->pluck('id')->all() ?? [];
        $existingIds = [];

        foreach ($folders as $index => $folderData) {
            $folder = isset($folderData['id'])
                ? ServerFolder::query()
                    ->where('user_id', $userId)
                    ->whereKey($folderData['id'])
                    ->first()
                : null;

            if (!$folder) {
                $folder = new ServerFolder(['user_id' => $userId]);
            }

            $folder->name = $folderData['name'] ?? 'Folder';
            $folder->sort = ($index * 10);
            $folder->save();

            $existingIds[] = $folder->id;

            $serverIds = collect($folderData['server_ids'] ?? [])
                ->unique()
                ->intersect($accessibleServerIds)
                ->values()
                ->all();

            $this->syncAssignments($folder, $serverIds, $userId);
        }

        ServerFolder::query()
            ->where('user_id', $userId)
            ->whereNotIn('id', $existingIds)
            ->each(fn (ServerFolder $folder) => $folder->delete());
    }

    private function syncAssignments(ServerFolder $folder, array $serverIds, int $userId): void
    {
        ServerFolderAssignment::query()
            ->where('folder_id', $folder->id)
            ->where('user_id', $userId)
            ->delete();

        if (empty($serverIds)) {
            return;
        }

        $rows = [];

        foreach ($serverIds as $position => $serverId) {
            $rows[] = [
                'folder_id' => $folder->id,
                'server_id' => $serverId,
                'user_id' => $userId,
                'position' => $position,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ServerFolderAssignment::query()->insert($rows);
    }

}
