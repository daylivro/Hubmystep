<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Challenge extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = [];

    /**
     * Get the participants for the challenge.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'challenge_users');
    }

    // create slug for challenge
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function rewards() : BelongsToMany
    {
        return $this->belongsToMany(Reward::class, 'challenge_rewards');
    }

    public function isActive(): bool
    {
        return $this->desabled_at === null;
    }
}
