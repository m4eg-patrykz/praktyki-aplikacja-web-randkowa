<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    protected $table = 'hobbys'; // bo tak nazywa się tabela w migracji

    public $timestamps = false;

    protected $fillable = [
        'label',
        'code',
    ];

    public function getHobbysList()
    {
        return $this->hasMany(Hobby::class);
    }
}
