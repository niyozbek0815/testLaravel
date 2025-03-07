<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id', 'slug', 'image'];
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parentCategories()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }

    public function posters()
    {
        return $this->hasMany(Poster::class);
    }
}
