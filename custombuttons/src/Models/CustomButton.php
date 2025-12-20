<?php

namespace Olivier\CustomButtons\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $text
 * @property string $url
 * @property ?string $icon
 * @property string $color
 * @property bool $new_tab
 * @property int $sort
 * @property bool $is_active
 */
class CustomButton extends Model
{
    protected $fillable = [
        'text',
        'url',
        'icon',
        'color',
        'new_tab',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'new_tab' => 'boolean',
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort');
    }
}
