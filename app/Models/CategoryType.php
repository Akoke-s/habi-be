<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\{HasSlug, SlugOptions};

class CategoryType extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = [];

    public function department(): Relation
    {
        return $this->belongsTo(Department::class);
    }

    public function products(): Relation
    {
        return $this->hasMany(Product::class);
    }

     /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
