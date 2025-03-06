<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['name'];
    public function posters()
    {
        return $this->belongsToMany(Poster::class, 'poster_hashtag');
    }
}