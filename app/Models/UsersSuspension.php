<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersSuspension extends Model
{
    use HasFactory;

    protected $table = 'users_suspensions';

    protected $fillable = [
        'uuid',
        'user_id',
        'status_id',
        'reason',
        'moderator_note',
        'permanent',
        'expires_at',
        'revoked_at',
    ];

    protected $casts = [
        'permanent' => 'boolean',
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(ModerationStatus::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('revoked_at')
            ->where(function (Builder $active) {
                $active->where('permanent', true)
                    ->orWhere('expires_at', '>', now());
            })
            ->whereHas('status', fn(Builder $status) => $status->where('code', 'ACTIVE'));
    }
}