<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Partner extends Model
{
    //
    protected $casts = ['is_active' => 'boolean'];

    /** Partners in the format the partner-logos component expects. Empty array when none are saved. */
    public static function forSite(): array
    {
        return Cache::rememberForever('partners', function () {
            return static::where('is_active', true)->orderBy('sort_order')->get()->map(fn ($p) => [
                'name' => $p->name,
                'country' => $p->country,
                'logo' => $p->logo ? 'storage/' . $p->logo : null,
                'url' => $p->url,
            ])->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('partners'));
        static::deleted(fn () => Cache::forget('partners'));
    }
}
