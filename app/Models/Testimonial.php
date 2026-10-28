<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Testimonial extends Model
{
    //
    protected $casts = ['is_active' => 'boolean'];

    /** Active testimonials as plain arrays, in the shape the component expects. */
    public static function forSite(): array
    {
        $rows = Cache::rememberForever('testimonials', function () {
            return static::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(['name', 'detail', 'quote', 'rating', 'photo'])
                ->toArray();
        });

        return array_map(function (array $row) {
            $row['photo'] = $row['photo'] ? asset('storage/' . $row['photo']) : null;
            return $row;
        }, $rows);
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('testimonials'));
        static::deleted(fn () => Cache::forget('testimonials'));
    }
}
