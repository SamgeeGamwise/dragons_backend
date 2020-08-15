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

class WeaponController extends Controller
{
    // POST
    public function addWeapon(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'character_id' => 'required|numeric|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        Weapon::create([
            'character_id' => $request->get('character_id'),
        ]);

        return response()->json(201);
    }

    // PUT

    public function updateWeapon(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data['data'], [
            '*.name' => 'required|string',
            '*.attack_bonus' => 'required|numeric',
            '*.damage' => 'required|string',
            '*.critical' => 'required|string',
            '*.range' => 'required|numeric',
            '*.type' => 'required|string',
            '*.ammo' => 'required|numeric',
            '*.equipped' => 'required|boolean',
            '*.order' => 'required|numeric',
            '*.notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        foreach ($data['data'] as $weapon) {
            Weapon::whereId($weapon['id'])
                ->where('character_id', '=', $character->id)
                ->update([
                    'name' => $weapon['name'],
                    'attack_bonus' => $weapon['attack_bonus'],
                    'damage' => $weapon['damage'],
                    'critical' => $weapon['critical'],
                    'range' => $weapon['range'],
                    'type' => $weapon['type'],
                    'ammo' => $weapon['ammo'],
                    'equipped' => $weapon['equipped'],
                    'order' => $weapon['order'],
                    'notes' => $weapon['notes'],
                ]);
        }

        return response()->json(201);
    }
    // DELETE

    public function deleteWeapon(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'character_id' => 'required|numeric',
            'weapon_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        Weapon::whereId($data['weapon_id'])
            ->where('character_id', '=', $character->id)
            ->delete();

        return response()->json(201);
    }
}
