<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WorkItem extends Model
{
    //
    protected $casts = ['is_featured' => 'boolean', 'is_active' => 'boolean'];

    // Single list used by the Filament form AND the website tabs. Add a line here for a new category.
    public const CATEGORIES = [
        'unloading'  => 'Container unloading',
        'deliveries' => 'Deliveries',
        'warehouse'  => 'Warehouse & packing',
        'customers'  => 'Happy customers',
    ];

    /** Grid items in the format the our-work-gallery component expects. */
    public static function gallery(): array
    {
        return Cache::rememberForever('work_gallery', function () {
            return static::where('is_active', true)
                ->orderBy('sort_order')->get()->map(fn ($w) => [
                    'type' => $w->type,
                    'category' => $w->category,
                    'src' => $w->image ? asset('storage/' . $w->image) : null,
                    'video' => $w->video_url,
                    'caption' => $w->caption,
                    'meta' => $w->meta,
                ])->all();
        });
    }

    /** The featured video, or null when there isn't one. */
    public static function featured(): ?array
    {
        return Cache::rememberForever('work_featured', function () {
            $w = static::where('is_active', true)->where('is_featured', true)->first();

            return $w ? [
                'title' => $w->caption,
                'caption' => $w->description,
                'video' => $w->video_url,
                'poster' => $w->image ? asset('storage/' . $w->image) : null,
            ] : null;
        });
    }

    protected static function booted(): void
    {
        // only one featured video at a time
        static::saving(function ($item) {
            if ($item->is_featured) {
                static::where('id', '!=', $item->id ?? 0)->update(['is_featured' => false]);
            }
        });

        $clear = function () {
            Cache::forget('work_gallery');
            Cache::forget('work_featured');
        };
        static::saved($clear);
        static::deleted($clear);
    }
}
