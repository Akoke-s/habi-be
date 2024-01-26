<?php

namespace App\Http\Controllers\API;

use App\Exceptions\IncorrectPasswordException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    LoginRequest,
    RegisterUserRequest,
    UpdatePasswordRequest,
    VerifyAccountRequest
};
use App\Http\Resources\UserResource;
use App\Services\{AuthService, EmailService};
use Illuminate\Http\{JsonResponse, Request, Response};
use App\Models\User;
use Illuminate\Support\Facades\{Auth, Hash,};

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

    /** login user
     * @param App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
    */

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if(!Auth::attempt(['email' => $request->validated()['email'], 'password' => $request->validated()['password']]))
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Invalid credentials'
                ], 200);
            }


            $user = User::where('email', $request->validated()['email'])->firstOrFail();

            $token = $user->createToken('userAccountToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => new UserResource($user),
                'token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch(\Throwable $e) {
            report($e);
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /** update user password
     * @param App\Http\Requests\UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
    */
    public function update_password(UpdatePasswordRequest $request): JsonResponse
    {
        try {

            $user = auth()->user();
            // check if old password is a match
            if(!Hash::check($request->validated('old_password'), $user->password)) {
                throw new IncorrectPasswordException();
            }

            $user->update([
                'password' => Hash::make($request->validated()['new_password'])
            ]);

            return response()->json([
                'message' => 'Password changed successfully',
            ], Response::HTTP_OK);

        } catch(\Throwable $exception) {
            report($exception);
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function check_email(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email:rfc,dns',
        ]);
        $user = User::whereEmail($validated['email'])->first();

        if($user) {
            return response()->json([
                'success' => true,
                'message' => 'User exists',
                'user' => new UserResource($user)
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ], 200);

    }
}
