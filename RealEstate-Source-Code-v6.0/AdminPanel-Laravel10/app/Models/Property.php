<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = "properties";
    protected $fillable = [
        'property_type_id',
        'property_category_id',
        'user_id',
        'city_id',
        'featured',
        'title',
        'description',
        'image_names',
        'size',
        'bed_room_count',
        'bath_room_count',
        'kitchen_room_count',
        'parking_count',
        'additional_features',
        'price',
        'currency',
        'address',
        'latitude',
        'longitude',
        'visible',
    ];

    public function property_type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function property_category()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}