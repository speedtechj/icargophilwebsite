<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TeamGroup extends Model
{
    //
    protected $casts = ['members' => 'array', 'is_active' => 'boolean'];

    public const ICONS = [
        'briefcase' => 'Briefcase (management)',
        'box'       => 'Box (warehouse)',
        'truck'     => 'Truck (drivers)',
        'chat'      => 'Chat (customer service)',
    ];

    /** Groups in the format the team-cards component expects. Empty array when none are saved. */
    public static function forSite(): array
    {
        return Cache::rememberForever('team_groups', function () {
            return static::where('is_active', true)->orderBy('sort_order')->get()->map(fn ($g) => [
                'name' => $g->name,
                'icon' => $g->icon,
                'text' => $g->text,
                'members' => collect($g->members ?? [])->map(fn ($m) => [
                    'name' => $m['name'] ?? '',
                    'role' => $m['role'] ?? '',
                    'text' => $m['text'] ?? null,
                    'photo' => ! empty($m['photo']) ? asset('storage/' . $m['photo']) : null,
                ])->all(),
            ])->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('team_groups'));
        static::deleted(fn () => Cache::forget('team_groups'));
    }
}
