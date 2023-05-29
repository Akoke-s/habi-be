<?php

namespace App\Models;

use App\Enums\{GenericStatusEnum, ProductTypeEnum};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => GenericStatusEnum::class,
        'type' => ProductTypeEnum::class
    ];

    public function category(): Relation
    {
        return $this->belongsTo(Category::class);
    }
}
