<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    protected $table = "app_settings";
    protected $fillable = [
        'id',
        'email',
        'website',
        'app_version',
        'about_us',
        'header_images',
        'privacy_policy',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'instagram_url',
    ];
}
