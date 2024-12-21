<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'miles',
    ];

    /**
     * Get the user that owns the UserMile
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the user's mouvments.
     *
     * @return HasMany
     */
    public function mouvments() : HasMany
    {
        return $this->hasMany(UserMileMouvment::class);
    }
}
