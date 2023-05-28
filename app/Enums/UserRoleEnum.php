<?php

namespace App\Enums;

enum UserRoleEnum: String
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case OVERSEER = 'overseer';
}