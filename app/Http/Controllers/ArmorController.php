<?php

namespace App\Http\Controllers;

use App\Ability;
use App\Armor;
use App\ArmorClass;
use App\Campaign;
use App\CampaignCharacter;
use App\Character;
use App\CharacterAbility;
use App\CharacterSavingThrow;
use App\CharacterSkill;
use App\Grapple;
use App\HealthPoint;
use App\Initiative;
use App\Note;
use App\NoteSection;
use App\SavingThrow;
use App\Skill;
use App\Spell;
use App\User;
use App\Weapon;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\Character as CharacterResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArmorController extends Controller
{
    // POST
    public function addArmor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'character_id' => 'required|numeric|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        Armor::create([
            'character_id' => $request->get('character_id'),
            'notes' => 'Crude armor consisting of thick furs and pelts.',
        ]);

        return response()->json(201);
    }

    // PUT
    public function updateArmor(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data['data'], [
            '*.name' => 'required|string',
            '*.ac_bonus' => 'required|numeric',
            '*.check_penalty' => 'required|numeric',
            '*.type' => 'required|string',
            '*.max_dex' => 'required|numeric',
            '*.spell_failure' => 'required|string',
            '*.speed' => 'required|numeric',
            '*.weight' => 'required|numeric',
            '*.equipped' => 'required|boolean',
            '*.order' => 'required|numeric',
            '*.notes' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        foreach ($data['data'] as $armor) {
            Armor::whereId($armor['id'])
                ->where('character_id', '=', $character->id)
                ->update([
                    'name' => $armor['name'],
                    'ac_bonus' => $armor['ac_bonus'],
                    'check_penalty' => $armor['check_penalty'],
                    'type' => $armor['type'],
                    'max_dex' => $armor['max_dex'],
                    'spell_failure' => $armor['spell_failure'],
                    'speed' => $armor['speed'],
                    'weight' => $armor['weight'],
                    'equipped' => $armor['equipped'],
                    'order' => $armor['order'],
                    'notes' => $armor['notes'],
                ]);
        }

        return response()->json(201);
    }

    // DELETE
    public function deleteArmor(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'character_id' => 'required|numeric',
            'armor_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        Armor::whereId($data['armor_id'])
            ->where('character_id', '=', $character->id)
            ->delete();

        return response()->json(201);
    }
}
