<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Add the casts for your JSON columns
    protected $casts = [
        'phones' => 'array',
        'social_links' => 'array',
    ];

    // Add all your database columns here so they can be mass-assigned.
    protected $fillable = [
        'name',
        'session_year',
        'logo',
        'favicon',
        'image',
        'phones',
        'email',
        'address',
        'location',
        'social_links',
    ];

    public function getLogoAttribute($logo)
    {
        return $logo ? asset($logo) : null;
    }

    public function getFaviconAttribute($favicon)
    {
        return $favicon ? asset($favicon) : null;
    }

    public function getImageAttribute($image)
    {
        return $image ? asset($image) : null;
    }
}
