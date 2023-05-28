<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\{JsonResponse, Response};

class AuthController extends Controller
{
    public function __construct(
        public AuthService $authService
    ){}
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->create_user($request);

            $token = $user->createToken('userAccountToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User registration successful',
                'user' => new UserResource($user),
                'token' => $token
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
