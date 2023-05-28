<?php

namespace App\Enum;

enum ProfileStatusEnum: String
{
    case ACTIVE = 'active';
    case DEACTIVATED = 'deactivated';
    case BANNED = 'banned';
    case DELETED = 'deleted';
}