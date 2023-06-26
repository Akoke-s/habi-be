<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function cart(): Relation
    {
        return $this->belongsTo(Cart::class);
    }

    public function size(): Relation
    {
        return $this->belongsTo(Size::class);
    }

    public function product(): Relation
    {
        return $this->hasOne(Product::class);
    }
}
