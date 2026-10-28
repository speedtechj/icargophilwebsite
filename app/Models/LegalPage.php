<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    //
    protected $casts = ['is_published' => 'boolean'];

    public const SLUGS = [
        'privacy-policy' => 'Privacy Policy',
        'terms'          => 'Terms of Service',
    ];
}
