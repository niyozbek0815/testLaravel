<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Poster;

class PosterRepository extends BaseRepository
{
    public function __construct(Poster $poster)
    {
        $this->model = $poster;
    }
    public function getPosters(array $filters)
    {

        $query = Poster::with(['hashtags', 'user', 'category', 'region', 'attributes'])
            ->where('status', true);

        // Sortlash
        $sortBy = $filters['sort_by'] ?? 'random';
        if ($sortBy === 'random') {
            $query->inRandomOrder();
        } else {
            $query->orderBy($sortBy, $filters['order_by'] ?? 'asc');
        }

        // Region filter
        if (!empty($filters['region_id'])) {
            $query->where('region_id', $filters['region_id']);
        }

        // Category filter
        if (!isset($filters['subcategory_id']) && isset($filters['category_id'])) {
            $categoryIds = Category::where('parent_id', $filters['category_id'])->pluck('id')->toArray();
            $categoryIds[] = $filters['category_id'];
            $query->whereIn('category_id', $categoryIds);
        } elseif (isset($filters['subcategory_id'])) {
            $query->where('category_id', $filters['subcategory_id']);
        }

        // Narx filter
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        return $query->paginate(20);
    }
    public function syncHashtags(Poster $poster, array $hashtags): void {
        $poster->hashtags()->attach($hashtags);
    }
    public function syncAttributes(Poster $poster, array $data): void
    {
            $attributes = collect($data)
                ->mapWithKeys(fn($attr) => [$attr['id'] => ['value' => $attr['value']]]);
            $poster->attributes()->sync($attributes);
    }
    public function find($id)
    {
        return $this->model::where('status', true)
            ->with(['user', 'category', 'region', 'hashtags', 'attributes'])->findOrFail($id);
    }
    public function incrementViews(Poster $poster)
    {
        $poster->increment('views');
    }
    public function update($id, array $data)
    {
        $model = $this->find($id);
        if (!empty($data['hashtags'])) {
            $model->hashtags()->sync($data['hashtags']);
        }
        $model->update($data);
        return $model;
    }
}
