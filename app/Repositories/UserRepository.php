<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function login(array $data)
    {
        return $this->model::where('email', $data['email'])->first();
    }
}
