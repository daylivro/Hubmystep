<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AtOurPartner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function isDone() : bool
    {
        return $this->done;
    }

    public function isLeft() : bool
    {
        return $this->left;
    }

    public static function ensureUserHasNotVisitInProgress() : bool
    {
        if(! auth()->check()) {
            return false;
        }

        return self::whereDate('created_at', today())->where([
            'done' => false,
            'left' => false
        ])->where('user_id', auth()->id())->exists();
    }

    public function winScanUrl() : Attribute
    {
        return new Attribute(
            get : fn($value) => asset("storage/". $value)
        );
    }
}
