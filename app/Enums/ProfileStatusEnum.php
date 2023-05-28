<?php

namespace App\Enums;

enum ProfileStatusEnum: String
{
    case ACTIVE = 'active';
    case DEACTIVATED = 'deactivated';
    case BANNED = 'banned';
    case DELETED = 'deleted';
}