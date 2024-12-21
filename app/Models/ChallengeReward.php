<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeReward extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the challenge that owns the ChallengeReward
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Get the reward that owns the ChallengeReward
     */
    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }
}
