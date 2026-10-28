<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DeliveryRate extends Model
{
    public const KEYS = ['luzon' => 'Luzon', 'visayas' => 'Visayas', 'mindanao' => 'Mindanao'];

    /** ['luzon' => ['eta' => '5–7 days', 'rate' => 'From $50'], ...] */
    public static function forSite(): array
    {
        return Cache::rememberForever('delivery_rates', function () {
            return static::all()->mapWithKeys(function ($r) {
                $days = $r->days_min === $r->days_max
                    ? $r->days_min . ' days'
                    : $r->days_min . '–' . $r->days_max . ' days';

                $amount = rtrim(rtrim(number_format((float) $r->starting_rate, 2), '0'), '.');

                return [$r->key => ['eta' => $days, 'rate' => 'From $' . $amount]];
            })->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('delivery_rates'));
        static::deleted(fn () => Cache::forget('delivery_rates'));
    }
}
