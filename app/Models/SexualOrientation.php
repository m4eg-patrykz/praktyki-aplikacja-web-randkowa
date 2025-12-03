<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SexualOrientation extends Model
{
    protected $table = 'sexual_orientations';

    public $timestamps = false;

    protected $fillable = ['label', 'code'];
}
