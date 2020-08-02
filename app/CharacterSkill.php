<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterSkill extends Model
{
    protected $fillable = [
        'character_id',
        'character_ability_id',
        'name',
        'rank_score',
        'misc_score',
        'order',
        'class_skill',
        'untrained_skill',
    ];
}
