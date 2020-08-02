<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    protected $fillable = [
        'character_id',
        'character_ability_id',
        'misc_bonus',
    ];
}
