<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false; // migracja nie ma timestamps

    protected $fillable = ['label', 'code'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions')
                    ->withPivot('granted')
                    ->withTimestamps();
    }
}
