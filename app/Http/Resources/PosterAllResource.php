<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PosterAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return   [
            'id'          => $this->id,
            'user'        => $this->user->name,
            'region'      => $this->region->name,
            'title'       => $this->title,
            'price'       => $this->price,
            'rooms'       => $this->rooms,
            'area'        => $this->area,
            'views'        => $this->views,
            'is_liked' => $this->is_liked,
            'negotiable' => (bool)$this->negotiable,
            'images'      => asset("storage/$this->images"),
            'hashtags' => HashtagResource::collection($this->hashtags),
            'created_at'  => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}