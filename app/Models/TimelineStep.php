<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TimelineStep extends Model
{
    //
    protected $casts = ['points' => 'array', 'is_active' => 'boolean'];

    public const ICONS = [
        'container' => 'Container',
        'unload'    => 'Box (unloading)',
        'check'     => 'Shield (checking)',
        'truck'     => 'Truck',
        'home'      => 'Home (delivered)',
    ];

    /** Steps in the format the container-timeline component expects. Empty array when none are saved. */
    public static function forSite(): array
    {
        return Cache::rememberForever('timeline_steps', function () {
            return static::where('is_active', true)->orderBy('sort_order')->get()->map(fn ($s) => [
                'icon' => $s->icon,
                'title' => $s->title,
                'text' => $s->text,
                'points' => $s->points ?? [],
                'photo' => $s->photo ? asset('storage/' . $s->photo) : null,
                'alt' => $s->photo_alt,
                'tag' => $s->tag,
            ])->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('timeline_steps'));
        static::deleted(fn () => Cache::forget('timeline_steps'));
    }
}
