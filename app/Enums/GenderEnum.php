<?php

namespace App\Enums;

enum GenderEnum: String
{
    case MEN = 'men';
    case WOMEN = 'women';
    case KIDS = ['boys', 'girls'];
}