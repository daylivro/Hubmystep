<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the category that owns the Reward
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(RewardCategory::class, 'reward_category_id');
    }


}
