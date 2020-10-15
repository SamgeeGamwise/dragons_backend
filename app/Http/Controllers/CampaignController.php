<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignCharacter;
use App\Character;
use App\Http\Resources\Campaign as CampaignResource;
use App\Jobs\SyncFirebase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class CampaignController extends Controller
{
    // GET
    public function all()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $campaigns = CampaignCharacter::select('campaigns.id', 'campaigns.name', 'campaigns.code', 'campaign_characters.owner')
            ->join('campaigns', 'campaigns.id', '=', 'campaign_characters.campaign_id')
            ->where("campaign_characters.user_id", "=", $user->id)
            ->get();

        return new CampaignResource($campaigns);
    }

    public function show($id)
    {
        return new CampaignResource(Campaign::findOrFail($id));
    }

    // POST
    public function addCampaign(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);


            $code = Str::random(8);

            $campaign = Campaign::create([
                'name' => $request->get('name'),
                'code' => $code,
            ]);

        $this->dispatch(new SyncFirebase($campaign->id, 'campaigns'));


        $campaignCharacter = CampaignCharacter::create([
                'user_id' => $user->id,
                'campaign_id' => $campaign->id,
                'owner' => 1
            ]);

        return response()->json(array(
                'id' => $campaign->id,
                'name' => $campaign->name,
                'code' => $campaign->code,
                'owner' => $campaignCharacter->owner
            ), 201);

    }

    public function joinCampaign(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $data = $request->all();

        $request->validate([
            'code' => 'required|string|max:255',
            'character_ids.*' => 'required|numeric|max:255',
        ]);

        $campaign = Campaign::where(
            'code', '=', $data['code']
        )->first();

        if ($campaign) {
            $existingCampaign = CampaignCharacter::where('campaign_id', '=', $campaign->id)->where('user_id', '=', $user->id)->first();
        } else {
            return response()->json(['message' => 'Could not find campaign with given code!'], 401);
        }

        if ($existingCampaign) return response()->json(['message' => 'Already joined this campaign!'], 401);

        foreach ($data['character_ids'] as $character_id) {
            if (!Character::whereId($character_id)->where('user_id', '=', $user->id)->first()) {
                return response()->json(['message' => 'Invalid Characters provided!'], 401);
            }
        }

        $character_ids = implode(',', $data['character_ids']);


        $campaignCharacter = CampaignCharacter::create([
            'user_id' => $user->id,
            'campaign_id' => $campaign->id,
            'character_id' => $character_ids,
            'owner' => 0
        ]);

        return response()->json(array(
            'id' => $campaign->id,
            'name' => $campaign->name,
            'code' => $campaign->code,
            'owner' => $campaignCharacter->owner
        ), 201);
    }

    // DELETE
    public function deleteCampaign(Request $request)
    {
        $campaignId = $request->all()['campaign_id'];
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $campaign = CampaignCharacter::where('campaign_id', '=', $campaignId)->where('user_id', '=', $user->id)->first();
        if (!$campaign) return response()->json(['message' => 'Invalid Character!'], 401);
        elseif ($campaign->owner === 1) {
            Campaign::whereId($campaignId)->delete();
        } else {
            $campaign->delete();
        }
        return response()->json(204);
    }
}
