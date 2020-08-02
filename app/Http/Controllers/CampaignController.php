<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\Http\Resources\Campaign as CampaignResource;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class CampaignController extends Controller
{
    // GET
    public function all()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return DB::table('campaign_characters')->join('campaigns', 'campaigns.id', '=', 'campaign_characters.campaign_id')
            ->join('characters', 'characters.id', '=', 'campaign_characters.character_id')
            ->select('campaigns.id', 'campaigns.name', 'campaigns.code')
            ->where("characters.user_id", "=", $user->id)->get();

        if (empty($campaigns)) {
            return new CampaignResource(null);
        }

        return  new CampaignResource($campaigns);
    }

    public function show($id)
    {
        return new CampaignResource(Campaign::findOrFail($id));
    }

    // POST
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);

        $campaign = Campaign::create($request->all());

        return (new CampaignResource($campaign))
            ->response()
            ->setStatusCode(201);
    }

    // DELETE
    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json(null, 204);
    }
}
