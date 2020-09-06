<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseAttack extends Model
{
    protected $fillable = [
        'base_bonus',
        'second_bonus',
        'third_bonus',
        'fourth_bonus',
    ];
}
