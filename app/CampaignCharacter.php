<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignCharacter extends Model
{
    protected $fillable = [
        'user_id',
        'character_id',
        'campaign_id',
        'owner',
    ];
}
