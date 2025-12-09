<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    protected $table = 'hobbys';

    public $timestamps = false;

    protected $fillable = [
        'label',
        'code',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_hobbys');
    }

}
