<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spell extends Model
{
    protected $fillable = [
        'name',
        'school_of_magic',
        'area',
        'casting_time',
        'components',
        'duration',
        'effect',
        'range',
        'saving_throw',
        'spell_resistance',
        'summary',
        'target',
    ];
}
