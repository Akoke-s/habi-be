<?php

namespace App\Services;

use App\Enums\EmailVerificationStatusEnum;
use App\Mail\UserRegistered;
use App\Models\VerifyEmail;
use Illuminate\Support\Facades\{DB, Mail};
use Carbon\Carbon;

class EmailService {

    /**
     * send welcome verification email.
     * @param object $user
    */

    public function send_welcome_verification_email($user) {
        return DB::transaction(function () use ($user){
            $verification = VerifyEmail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'code' => mt_rand(100000, 999999),
                    'status' => EmailVerificationStatusEnum::UNVERIFIED,
                    'expires_in' => Carbon::now()->addHours(24)
                ]
            );

            Mail::to($user->email)->send(new UserRegistered($user, $verification));

            return $verification;
        });
    }
}