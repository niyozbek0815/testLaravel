<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'region_id',
        'title',
        'description',
        'price',
        'rooms',
        'bathrooms',
        'area',
        'type',
        'furnished',
        'garage',
        'negotiable',
        'images',
        'views',
        'status'
    ];
    protected $appends = ['is_liked'];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function region()
    {
        return $this->belongsTo(Regions::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'poster_hashtag');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'poster_likes');
    }
    public function getIsLikedAttribute()
    {
        $userId = Auth::id();
        if (!$userId) {
            return false;
        }
        // Agar user `likes` bo'limida mavjud bo'lsa, true qaytariladi
        return $this->likes()->where('user_id', $userId)->exists();
    }
}