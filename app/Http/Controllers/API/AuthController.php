<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Services\{AuthService, EmailService};
use Illuminate\Http\{JsonResponse, Response};
use App\Http\Requests\VerifyAccountRequest;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $authService,
        public EmailService $emailService
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

    /** verify user email
     * @param App\Http\Requests\VerifyAccountRequest $request
     * @return \Illuminate\Http\JsonResponse
    */

    public function verify_user_email(VerifyAccountRequest $request): JsonResponse
    {
        try {
            return $this->emailService->verify_email($request->validated()['code']);
        } catch(\Throwable $e) {
            report($e);
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
