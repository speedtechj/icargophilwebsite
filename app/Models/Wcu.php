<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Wcu extends Model
{
    //
    public static function photo(): ?array
    {
        $row = Cache::rememberForever('wcu', fn () => static::first()?->only(['image', 'alt']) ?? []);

        if (empty($row['image'])) {
            return null;
        }

        return ['url' => asset('storage/' . $row['image']), 'alt' => $row['alt'] ?? null];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('wcu'));
        static::deleted(fn () => Cache::forget('wcu'));
    }
}
