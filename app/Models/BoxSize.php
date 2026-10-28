<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BoxSize extends Model
{
    //
    protected $casts = [
        'points' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    /** Boxes in the format the rates-box-sizes component expects. Empty array when none are saved. */
    public static function forSite(): array
    {
        return Cache::rememberForever('box_sizes', function () {
            return static::where('is_active', true)->orderBy('sort_order')->get()->map(function ($b) {
                $amount = rtrim(rtrim(number_format((float) $b->price, 2), '0'), '.');

                return [
                    'name' => $b->name,
                    'dims' => $b->dimensions,
                    'fits' => $b->best_for,
                    'price' => '$' . $amount,
                    'scale' => (int) $b->scale,
                    'popular' => $b->is_popular,
                    'points' => $b->points ?? [],
                ];
            })->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('box_sizes'));
        static::deleted(fn () => Cache::forget('box_sizes'));
    }
}
