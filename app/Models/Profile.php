<?php

namespace App\Models;

use App\Enums\ProfileStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => ProfileStatusEnum::class
    ];
}
