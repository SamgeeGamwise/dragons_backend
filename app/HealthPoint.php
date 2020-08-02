<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthPoint extends Model
{
    protected $fillable = [
        'character_id',
        'total_hp',
        'damage',
        'non_lethal',
    ];
}
