<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StatCounter extends Model
{
    //
    protected $casts = ['is_active' => 'boolean'];

    public const ICONS = [
        'box'      => 'Box',
        'calendar' => 'Calendar',
        'pin'      => 'Location pin',
        'heart'    => 'Heart',
    ];

    /** Active counters as plain arrays (cached), in the shape the component expects. */
    public static function forSite(): array
    {
        return Cache::rememberForever('stat_counters', function () {
            return static::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(['icon', 'value', 'suffix', 'label', 'text'])
                ->toArray();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('stat_counters'));
        static::deleted(fn () => Cache::forget('stat_counters'));
    }
}
