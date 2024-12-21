<?php

namespace App\Models;

use App\Observers\PartnerObserver;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([PartnerObserver::class])]
class Partner extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = [];

    /**
     * Get the category that owns the Partner
     */
    public function category()
    {
        return $this->belongsTo(PartnerCategory::class, 'partner_category_id');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    /**
     * Get the location attribute
     */
    public function location(): Attribute
    {
        return Attribute::make(get: fn($value) => json_decode($value), set: fn($value) => json_encode($value));
    }

    public function image(): Attribute
    {
        return new Attribute(get: fn($value) => asset("storage/{$value}"));
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }

    public function qrCode(): Attribute
    {
        return new Attribute(
            get: fn($value) => asset("storage/" . $value)
        );
    }
}
