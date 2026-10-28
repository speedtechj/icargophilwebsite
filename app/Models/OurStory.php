<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OurStory extends Model
{
    //
    protected $table = 'our_stories';
    protected $casts = ['paragraphs' => 'array', 'milestones' => 'array'];

    /** The story for the website, or null when nothing is saved yet. */
    public static function data(): ?array
    {
        return Cache::rememberForever('our_story', function () {
            $s = static::first();

            return $s ? [
                'eyebrow' => $s->eyebrow,
                'title' => $s->title,
                'lead' => $s->lead,
                'paragraphs' => $s->paragraphs ?? [],
                'quote' => $s->quote,
                'founder' => $s->founder,
                'role' => $s->role,
                'since' => $s->since,
                'photo' => $s->photo ? asset('storage/' . $s->photo) : null,
                'photo_alt' => $s->photo_alt,
                'milestones' => $s->milestones ?? [],
            ] : null;
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('our_story'));
        static::deleted(fn () => Cache::forget('our_story'));
    }
}
