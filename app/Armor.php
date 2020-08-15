<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Armor extends Model
{
    protected $fillable = [
        'character_id', 'name', 'attack_bonus', 'damage', 'critical', 'range', 'type', 'ammo', 'equipped', 'order', 'notes',
    ];
}
