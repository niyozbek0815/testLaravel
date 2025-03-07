<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PosterAllRequest;
use App\Repositories\PosterRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PosterReadResource;
use App\Http\Resources\PosterAllResource;
use App\Http\Requests\PosterStoreRequest;
use App\Http\Requests\PosterUpdateRequest;
use App\Models\Poster;
use App\Service\PosterService;

class PosterController extends Controller
{
    protected $posterRepository, $posterService;

    public function __construct(PosterRepository $posterRepository, PosterService $posterService)
    {
        $this->posterRepository = $posterRepository;
        $this->posterService = $posterService;
    }

    public function index(PosterAllRequest $request)
    {
        $data = $request->validated();
        return $this->successResponse(
            "E'lonlar muvaffaqiyatli olindi!",
            PosterAllResource::collection($this->posterRepository->getPosters($data))
        );
    }



    public function store(PosterStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successResponse(
            "E'lon muvaffaqiyatli qo'shildi!",
            $this->posterService->storePoster($data)
        );
    }


    public function show(int $id): JsonResponse
    {
        return $this->successResponse(
            "Poster read.",
            $this->posterService->getPosterWithViews($id)
        );
    }

    public function update(PosterUpdateRequest $request, int $id): JsonResponse
    {

        $data = $request->validated();
        return $this->successResponse(
            "E'lon muvaffaqiyatli yangilandi!",
            $this->posterService->getPosterWithUpdate($id, $data)
        );
    }


    public function destroy(int $id): JsonResponse
    {
        $poster = $this->posterRepository->find($id);
        $this->posterService->deleteImage($poster['images']);
        $this->posterRepository->delete($id);

        return $this->successResponse("E'lon muvaffaqiyatli o'chirildi!");
    }

    public function toggleLike(int $id)
    {
        // Agar like bosilgan bo‘lsa, unlike qiladi, aks holda like qiladi
        $data = $this->posterService->toggleLike($id);
        return $this->successResponse(
            "Like holati o‘zgartirildi!",
        );
    }
}
