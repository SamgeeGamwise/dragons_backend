<?php

namespace App\Http\Controllers;

use App\Character;
use App\Weapon;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class WeaponController extends Controller
{

    /**
     * Create new character weapon
     *
     * @param Request $request
     * @return JsonResponse
     */
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
            'notes' => 'A short knife with a pointed and edged blade.',
        ]);

        return response()->json(201);
    }

    /**
     * Update character weapon
     *
     * @param Request $request
     * @return JsonResponse
     */
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

        foreach ($data['data'] as $index=>$weapon) {
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
                    'order' => $index,
                    'notes' => $weapon['notes'],
                ]);
        }

        return response()->json(201);
    }

    /**
     * Delete character weapon
     *
     * @param Request $request
     * @return JsonResponse
     */
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
