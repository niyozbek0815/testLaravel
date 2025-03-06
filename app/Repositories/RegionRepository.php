<?php

namespace App\Repositories;

use App\Http\Resources\RegionsResource;
use App\Models\Regions;
use Illuminate\Support\Facades\Cache;

class RegionRepository
{
    public function getAll()
    {
        return Cache::remember('region', 3600, function () {

            return RegionsResource::collection(
                Regions::get()
            );
        });
    }
}