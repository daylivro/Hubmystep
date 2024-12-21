<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Enums\RoleEnum;
use Illuminate\Support\Str;
use App\Helpers\DateTimeHelper;
use App\Observers\UserObserver;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, UseDevices, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine if the user can access the given panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->roles->first();
    }

    /**
     * Get the challenges that belong to the user.
     * @return BelongsToMany
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class, 'challenge_users')->withPivot('completed_at', 'desabled_at');
    }

    /**
     * Determine if the user is super admin.
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleEnum::SUPER_ADMIN);
    }

    /**
     * Set username attribute.
     * @return Attribute
     */
    public function username(): Attribute
    {
        return new Attribute(set: fn() => Str::ulid());
    }

    /**
     * boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->username) {
                $user->username = Str::ulid();
            }
            $user->location = json_encode($user->location);
        });

        /**
         * Release unique fields so that they can be reused.
         */
        static::deleting(function (User $user) {
            $user->email = DateTimeHelper::appendTimestamp($user->email, '::deleted_');
            $user->username = DateTimeHelper::appendTimestamp($user->username, '::deleted_');
            $user->saveQuietly();
        });
    }

    /**
     * Get the password histories that belong to the user.
     */
    public function passwordHistories(): HasMany
    {
        return $this->hasMany(PasswordHistory::class);
    }

    /**
     * Get the userMile that owns the user.
     *
     * @return HasOne
     */
    public function userMile(): HasOne
    {
        return $this->hasOne(UserMile::class);
    }
    /**
     * Get the miles that owns the user.
     *
     * @return Attribute
     */
    public function mile(): Attribute
    {
        return new Attribute(
            get: fn() => $this->userMile->miles ?? 0
        );
    }

    public function isActive() : bool
    {
        return $this->desabled_at === null;
    }

    public function desable(): self
    {
        $this->desabled_at = now();
        $this->save();
        return $this;
    }

    public function enable(): self
    {
        $this->desabled_at = null;
        $this->save();
        return $this;
    }

    public function shares() : HasMany
    {
        return $this->hasMany(DailyShare::class);
    }
}
