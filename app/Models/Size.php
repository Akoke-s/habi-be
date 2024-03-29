<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function color(): Relation
    {
        return $this->belongsTo(Color::class);
    }

    // protected $with = 'stock';
    
    public function stock(): Relation
    {
        return $this->hasOne(Stock::class);
    }
}
