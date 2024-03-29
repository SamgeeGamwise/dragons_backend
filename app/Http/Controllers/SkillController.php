<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterAbility;
use App\CharacterSkill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class SkillController extends Controller
{
    // POST
    public function addSkill(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'character_id' => 'required|numeric|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($request->get('character_id'))->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        CharacterSkill::create([
            'character_id' => $character->id,
            'character_ability_id' => 1,
            'name' => 'New Skill',
            'order' => 0,
        ]);

        return response()->json(201);
    }

    // PUT

    public function updateSkills(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data['data'], [
            '*.name' => 'required|string',
            '*.ability_id' => 'required|numeric',
            '*.character_ability_id' => 'required|numeric',
            '*.rank_score' => 'required|numeric',
            '*.misc_score' => 'required|numeric',
            '*.class_skill' => 'required|boolean',
            '*.untrained_skill' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        $abilities = CharacterAbility::select('id', 'ability_id')->where('character_id', '=', $character->id)->get();

        foreach ($data['data'] as $index=>$skill) {

            foreach ($abilities as $ability) {
                if($ability->ability_id === $skill['ability_id'])
                    $skill['character_ability_id'] = $ability->id;
            }

            CharacterSkill::whereId($skill['id'])
                ->where('character_id', '=', $character->id)
                ->update([
                    'name' => $skill['name'],
                    'character_ability_id' => $skill['character_ability_id'],
                    'rank_score' => $skill['rank_score'],
                    'misc_score' => $skill['misc_score'],
                    'class_skill' => $skill['class_skill'],
                    'untrained_skill' => $skill['untrained_skill'],
                    'order' => $index,
                ]);
        }

        return response()->json(201);
    }
    // DELETE

    public function deleteSkills(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'character_id' => 'required|numeric',
            'skill_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        CharacterSkill::whereId($data['skill_id'])
            ->where('character_id', '=', $character->id)
            ->delete();

        return response()->json(201);
    }
}
