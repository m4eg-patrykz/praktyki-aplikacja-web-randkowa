<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['label', 'code'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions')
                    ->withPivot('granted')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
