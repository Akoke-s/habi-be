<?php

namespace App\Services;

use App\Enums\EmailVerificationStatusEnum;
use App\Mail\UserRegistered;
use App\Models\{User, VerifyEmail};
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\Http\{Response};
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

    /** verify email
     * @param string $code
     * 
    */

    public function verify_email($code) {
        if($codeFound = VerifyEmail::where('code', $code)->first()) {
            if(Carbon::parse($codeFound->expires_in)->diffInHours(Carbon::now()) < 24 && $codeFound->status == EmailVerificationStatusEnum::UNVERIFIED) {
                //update the verification model
                return DB::transaction(function() use($codeFound) {
                    
                    $codeFound->update(
                        [
                            'status' => EmailVerificationStatusEnum::VERIFIED,
                        ]
                    );
                    
                    $user = User::where('id', $codeFound->user_id)->first();

                    $user->email_verified_at = Carbon::now();
                    $user->save();
                    
                    return response()->json([
                        'message' => 'Verification successful',
                        'data' => $codeFound
                    ], Response::HTTP_CREATED);
                });
            }

            return response()->json([
                'message' => 'This code is expired',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'The code does not exist',
        ], Response::HTTP_NOT_FOUND);
    }
}