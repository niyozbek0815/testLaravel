<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRespository;
use App\Repositories\RegionRepository;

class RegionsController extends Controller
{
    protected $regionRepository, $categoryRepository;
    public function __construct(RegionRepository $regionRepository, CategoryRespository $categoryRespository)
    {
        $this->regionRepository = $regionRepository;
        $this->categoryRepository = $categoryRespository;
    }

    public function index()
    {

        return response()->json([
            'success' => true,
            'message' => 'Regions And Categories return.',
            'regions' => $this->regionRepository->getAll(),
            'categories' => $this->categoryRepository->getAll()
        ]);
    }
}