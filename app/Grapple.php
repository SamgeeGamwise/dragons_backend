<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grapple extends Model
{
    protected $fillable = [
        'character_id',
        'character_ability_id',
        'base_bonus',
        'size_bonus',
        'misc_bonus',
    ];
}
