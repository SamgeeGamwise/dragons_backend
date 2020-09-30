<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpellLevel extends Model
{
    protected $fillable = [
        'spells_id',
        'level',
        'class',

    ];
}
