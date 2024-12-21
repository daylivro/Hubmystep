<?php

namespace App\Models;

use App\Models\Challenge;
use Spatie\ModelStates\HasStates;
use App\States\Challenge\Completed;
use App\States\Challenge\InProgress;
use Illuminate\Database\Eloquent\Model;
use App\States\Challenge\ChallengeState;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChallengeUser extends Model
{
    use HasFactory, HasStates;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'state' => ChallengeState::class,
            'start_at' => 'datetime',
        ];
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Get the user that owns the ChallengeUser
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function remainingDays(): int
    {
        // TODO: use start_at to calculate remaining days
        $days = now()->diffInDays($this->start_at);
        return $this->duration - $days;
    }

    public function currentParts($user): int
    {
        $shares = DailyShare::query()
            ->where('user_id', $user->id)
            ->whereBetween('date', [$this->start_at->format('Y-m-d'), today()])
            ->sum('shares');
        return (int) $shares;
    }

    public function remainingParts($user): int
    {
        if (is_null($this->goal)) {
            return $this->challenge->number_of_parts - $this->currentParts($user);
        }

        if ($this->currentParts($user) >= $this->goal) {
            return 0;
        }

        return $this->goal - $this->currentParts($user);
    }

    public function heWon(): bool
    {
        return $this->currentParts(auth()->user()) >= $this->goal;
    }

    public static function getAll()
    {
        $challengeInProgress = ChallengeUser::query()
            ->whereState('state', InProgress::class)
            ->get();
        return $challengeInProgress;
    }
}
