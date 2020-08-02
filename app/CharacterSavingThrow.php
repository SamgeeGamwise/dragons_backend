<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterSavingThrow extends Model
{
    protected $fillable = [
        'character_id',
        'saving_throw_id',
        'character_ability_id',
        'base_score',
        'magic_score',
        'misc_score',
        'temp_score',
    ];
}
