<?php

namespace App\Models;

use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\{HasSlug, SlugOptions};

class Category extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = [];

    // protected $with = ['departments'];

    public function departments(): Relation
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */

    // public function scopeOfGender($query, $type)
    // {
    //     return $query->where('gender', $type);
    // }

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
