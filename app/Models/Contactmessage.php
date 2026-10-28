<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactmessage extends Model
{
    //
    public static function topics(): array
    {
        return [
            'balikbayan' => 'Balikbayan box',
            'parcel'     => 'Parcel or cargo',
            'pickup'     => 'Request a pickup',
            'business'   => 'Business or bulk shipping',
            'other'      => 'Something else',
        ];
    }

    public static function destinations(): array
    {
        return [
            'luzon'    => 'Luzon',
            'visayas'  => 'Visayas',
            'mindanao' => 'Mindanao',
            'unsure'   => 'Not sure yet',
        ];
    }

    public static function boxSizes(): array
    {
        return [
            'small'  => 'Small',
            'medium' => 'Medium',
            'large'  => 'Large',
            'xl'     => 'Extra large',
            'unsure' => 'Not sure yet',
        ];
    }

    public static function replyOptions(): array
    {
        return [
            'any'   => 'Any way is fine',
            'call'  => 'Call me',
            'text'  => 'Text or chat message',
            'email' => 'Email me',
        ];
    }

    public static function statuses(): array
    {
        return [
            'new'         => 'New',
            'in_progress' => 'In progress',
            'done'        => 'Done',
            'spam'        => 'Spam',
        ];
    }
}
