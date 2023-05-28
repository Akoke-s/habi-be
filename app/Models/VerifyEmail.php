<?php

namespace App\Models;

use App\Enums\EmailVerificationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyEmail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => EmailVerificationStatusEnum::class
    ];
}
