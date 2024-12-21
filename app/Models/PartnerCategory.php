<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerCategory extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = [];

    /**
     * Get the partners for the partner category.
     */
    public function partners()
    {
        return $this->hasMany(Partner::class);
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

    public function image(): Attribute
    {
        return new Attribute(get: fn ($value) => asset("storage/{$value}"));
    }

}
