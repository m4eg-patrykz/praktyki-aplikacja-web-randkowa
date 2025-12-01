<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'label',
        'code',
    ];

    public function suspensions()
    {
        return $this->hasMany(UsersSuspension::class, 'status_id');
    }
}