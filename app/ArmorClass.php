<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArmorClass extends Model
{
    protected $fillable = [
        'character_id',
        'character_ability_id',
        'armor_bonus',
        'size_bonus',
        'natural_bonus',
        'misc_bonus',
    ];
}
