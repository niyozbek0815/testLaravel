<?php

namespace App\Service;

use App\Http\Resources\PosterReadResource;
use Illuminate\Support\Str;
use App\Repositories\PosterRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class PosterService
{
    protected $posterRepository;
    public function __construct(PosterRepository $posterRepository)
    {
        $this->posterRepository = $posterRepository;
    }

    public function storePoster(array $data)
    {
        DB::beginTransaction();
        try {
            $data['images'] = $this->saveBase64Image($data['images'] ?? null);
            $data['user_id'] = Auth::id();
            $poster = $this->posterRepository->create($data);
            $this->posterRepository->syncHashtags($poster, $data['hashtags'] ?? []);
            if (!empty($data['attributes'])) {
                $this->posterRepository->syncAttributes($poster, $data['attributes']);
            }
            DB::commit();
            return new PosterReadResource($poster->load(['hashtags', 'user', 'category', 'region', 'attributes']));
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Poster yangilanmadi: " . $e->getMessage());
        }
    }
    public function getPosterWithViews(int $id)
    {
        $poster = $this->posterRepository->find($id);
        $this->handleViews($poster);
        return new PosterReadResource($poster);
    }
    public function getPosterWithUpdate(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            if (!empty($data['images'])) {
                $data['images'] = $this->saveBase64Image($data['images'] ?? null);
            }

            $poster = $this->posterRepository->update($id, $data);

            DB::commit();

            return new PosterReadResource($poster);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Poster yangilanmadi: " . $e->getMessage());
        }
    }
    private function handleViews($poster)
    {
        $ip = request()->ip();
        $key = "poster_views:{$poster->id}:{$ip}";

        if (!Redis::get($key)) {
            $this->posterRepository->incrementViews($poster);
            Redis::setex($key, 3600, true); // 1 soatga saqlanadi
        }
    }
    public function toggleLike(int $id)
    {
        $poster = $this->posterRepository->find($id);
        $user = Auth::user();


        $user->likedPosters()->toggle($poster->id);

        return "Like holati o‘zgartirildi!";
    }
    /**
     * Base64 formatdagi rasmni saqlash
     */

    private function saveBase64Image(?string $base64Image): ?string
    {
        if (!$base64Image || !preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
            return null;
        }

        $extension = $matches[1];
        $imageData = base64_decode(substr($base64Image, strpos($base64Image, ',') + 1));

        if ($imageData === false) {
            return null;
        }

        $fileName = 'images/' . Str::random(10) . '.' . $extension;
        Storage::disk('public')->put($fileName, $imageData);
        return $fileName;
    }
    public function deleteImage(?string $filePath): void
    {
        if ($filePath) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
