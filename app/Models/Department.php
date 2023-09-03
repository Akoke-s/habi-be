<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\{HasSlug, SlugOptions};

class Department extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = [];

    public function category(): Relation
    {
        return $this->belongsTo(Category::class);
    }

    public function types(): Relation
    {
        return $this->hasMany(CategoryType::class, 'department_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, CategoryType::class);
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
