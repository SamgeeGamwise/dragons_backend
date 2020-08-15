<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteSection extends Model
{
    protected $fillable = [
        'character_id',
        'name',
        'order',
    ];
}
