<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TeamPage extends Model
{
    //
    public static function data(): ?array
    {
        return Cache::rememberForever('team_page', function () {
            $p = static::first();

            return $p ? [
                'eyebrow' => $p->eyebrow,
                'title' => $p->title,
                'subtitle' => $p->subtitle,
                'team_photo' => $p->team_photo ? asset('storage/' . $p->team_photo) : null,
                'team_photo_caption' => $p->team_photo_caption,
                'leader' => $p->leader_name ? [
                    'name' => $p->leader_name,
                    'role' => $p->leader_role,
                    'text' => $p->leader_text,
                    'photo' => $p->leader_photo ? asset('storage/' . $p->leader_photo) : null,
                ] : null,
            ] : null;
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('team_page'));
        static::deleted(fn () => Cache::forget('team_page'));
    }
}
