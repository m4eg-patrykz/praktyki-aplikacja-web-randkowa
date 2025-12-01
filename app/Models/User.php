<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Domyślnie: protected $table = 'users'; protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'email',
        'password',
        'phone_country_code',
        'phone_number',
        'phone_verified_at',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    // RELACJA DO ROLI
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // SPRAWDZENIE ROLI (po polu code: USER, MOD, ADMIN)
    public function hasAnyRole(array|string $roles): bool
    {
        if (!$this->role) {
            return false;
        }

        // pozwól podać albo tablicę, albo string "ADMIN|MOD|USER"
        if (!is_array($roles)) {
            $roles = explode('|', $roles);
        }

        $current = strtoupper($this->role->code);

        foreach ($roles as $role) {
            if ($current === strtoupper($role)) {
                return true;
            }
        }

        return false;
    }

    // SPRAWDZENIE UPRAWNIENIA (po polu code w permissions)
    public function hasPermission(string $permissionCode): bool
    {
        if (!$this->role) {
            return false;
        }

        // role->permissions przez pivot roles_permissions (granted = 1)
        return $this->role
            ->permissions()
            ->where('code', $permissionCode)
            ->wherePivot('granted', true)
            ->exists();
    }

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function phoneVerifications()
    {
        return $this->hasMany(PhoneVerification::class);
    }
    public function suspensions()
    {
        return $this->hasMany(UsersSuspension::class, 'user_id');
    }
    public function getActiveSuspension(): ?array
    {
        $suspension = $this->suspensions()->active()->first();

        return $suspension ? $suspension->toArray() : null;
    }

    public function hasActiveSuspension(): bool
    {
        return (bool) $this->getActiveSuspension();
    }
}
