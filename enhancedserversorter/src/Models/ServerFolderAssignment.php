<?php

namespace Olivier\EnhancedServerSorter\Models;

use App\Models\Server;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerFolderAssignment extends Model
{
    protected $table = 'enhanced_server_folder_server';

    protected $fillable = [
        'folder_id',
        'server_id',
        'user_id',
        'position',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(ServerFolder::class, 'folder_id');
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
}
