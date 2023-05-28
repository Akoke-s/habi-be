<?php

namespace App\Enum;

enum UserRoleEnum: String
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case OVERSEER = 'overseer';
}