<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{

    protected $casts = ['hours' => 'array'];

    public static function current(): self
{
    $attributes = Cache::rememberForever('site_settings', function () {
        return static::first()?->getAttributes() ?? [];
    });

    return (new static)->newFromBuilder($attributes);
}

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings'));
        static::deleted(fn () => Cache::forget('site_settings'));
    }

    public function hoursRows(): array
    {
        $rows = collect($this->hours ?? [])->map(function ($r) {
            $closed = ! empty($r['closed']) || empty($r['open']) || empty($r['close']);

            return [
                'label' => $r['label'] ?? '',
                'days'  => array_map('intval', $r['days'] ?? []),
                'time'  => $closed ? 'Closed' : Carbon::parse($r['open'])->format('g:i A') . ' – ' . Carbon::parse($r['close'])->format('g:i A'),
                'open'  => $closed ? null : Carbon::parse($r['open'])->format('H:i'),
                'close' => $closed ? null : Carbon::parse($r['close'])->format('H:i'),
            ];
        })->all();

        return $rows ?: [
            ['label' => 'Monday – Friday', 'time' => '9:00 AM – 6:00 PM', 'days' => [1, 2, 3, 4, 5], 'open' => '09:00', 'close' => '18:00'],
            ['label' => 'Saturday', 'time' => '9:00 AM – 3:00 PM', 'days' => [6], 'open' => '09:00', 'close' => '15:00'],
            ['label' => 'Sunday', 'time' => 'Closed', 'days' => [7]],
        ];
    }
}
