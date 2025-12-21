<?php

namespace Olivier\EnhancedServerSorter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServerFolder extends Model
{
    protected $table = 'enhanced_server_folders';

    protected $fillable = [
        'user_id',
        'name',
        'sort',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(ServerFolderAssignment::class, 'folder_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(config('panel.auth.models.user'), 'user_id');
    }
}
