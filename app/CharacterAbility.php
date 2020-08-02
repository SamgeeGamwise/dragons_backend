<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterAbility extends Model
{
    protected $fillable = [
        'character_id',
        'ability_id',
        'score',
        'temp_score',
    ];
}
