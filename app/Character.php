<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'class',
        'experience',
        'multi_class',
        'multi_experience',
        'prestige_class',
        'prestige_experience',
        'race',
        'alignment',
        'size',
        'gender',
        'base_attack',
        'speed',
    ];
}
