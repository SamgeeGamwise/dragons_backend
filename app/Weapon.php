<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */
class Weapon extends Model
{
    protected $fillable = [
        'character_id', 'name', 'attack_bonus', 'damage', 'critical', 'range', 'type', 'ammo', 'equipped', 'order', 'notes',
    ];
}
