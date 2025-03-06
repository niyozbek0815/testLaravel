<?php

namespace App\Repositories;

use App\Http\Resources\CategoriesResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRespository
{
    public function getAll()
    {
        return Cache::remember('category', 3600, function () {
            return CategoriesResource::collection(
                Category::whereNull('parent_id')->with('subCategories')->get()
            );
        });
    }
}