<?php

namespace App\Services;

use App\Enums\{ProfileStatusEnum, UserRoleEnum};
use App\Models\{Profile, User};
use Illuminate\Support\Facades\{DB, Hash};

class AuthService {

    public function __construct(
        public EmailService $emailService
    ){}
    /** create a new user account
    * @param App\Http\Requests\RegisterUserRequest|obj $userDetails
    * @return App\Models\User
    */
    public function create_user($userDetails): User
    {
        return DB::transaction(function() use ($userDetails) {
            $user = User::create([
                'firstname' => $userDetails['firstname'],
                'lastname' => $userDetails['lastname'],
                'email' => $userDetails['email'],
                'role' => UserRoleEnum::OVERSEER,
                'password' => Hash::make($userDetails['password'])
            ]);

            $this->emailService->send_welcome_verification_email($user);
            $this->create_user_profile($user);
            return $user;
        });
    }

    /** create user profile
    * @param App\Models\User $user
    * @return App\Models\Profile
    */
    public function create_user_profile($user): Profile
    {
        return DB::transaction(function() use ($user) {
            return Profile::create([
                'user_id' => $user->id,
                'status' => ProfileStatusEnum::ACTIVE
            ]);
        });
    }
}