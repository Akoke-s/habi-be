<?php

namespace App\Enums;

enum EmailVerificationStatusEnum: String
{
    case VERIFIED = 'verified';
    case UNVERIFIED = 'unverified';
}