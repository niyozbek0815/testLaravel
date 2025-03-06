<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistredRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    protected $userRespository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRespository = $userRepository;
    }
    /**
     * Register a new user.
     */
    public function register(RegistredRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRespository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login the user and return an access token.
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRespository->login($data);
        if (!Hash::check($data['password'], $user->password)) {

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => ["password" => [
                    "Password is incorrect."
                ]],
            ], 422));
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'User Return',
            'user' => $request->user()
        ]);
    }
    /**
     * Logout the user (revoke token).
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
