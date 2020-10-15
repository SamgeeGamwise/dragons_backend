<?php

namespace App\Http\Controllers;

use App\Spell;
use App\SpellLevel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpellsController extends Controller
{
    //  GET
    public function search(Request $request)
    {

        $search = $request->query("search");
        $school = $request->query("school");
        $class = $request->query("class");
        $level = $request->query("level");

        if (!isset($search) && !isset($school) && !isset($class) && !isset($level))
            return response()->json(400);

        $query = Spell::select(
            'spells.id',
            'spells.name',
            'spells.school_of_magic',
            'spells.area',
            'spells.casting_time',
            'spells.components',
            'spells.duration',
            'spells.effect',
            'spells.range',
            'spells.saving_throw',
            'spells.spell_resistance',
            'spells.summary',
            'spells.target'
        )->join('spell_levels', 'spell_levels.spells_id', '=', 'spells.id');

        if (isset($search))
            $query->where('spells.name', 'LIKE', '%' . $search . '%');

        if (isset($school))
            $query->where('spells.school_of_magic', 'LIKE', '%' . $school . '%');

        if (isset($class))
            $query->where('spell_levels.class', 'LIKE', '%' . $class . '%');

        if (isset($level))
            $query->where('spell_levels.level', '=', $level);
        $query->groupBy('spells.id');
        $query->orderBy('spells.name', 'ASC');
        $query->limit(10);

        $spells = $query->get();

        foreach ($spells as $spell) {
            $spell->level = SpellLevel::select(
                'level',
                'class'
            )->where('spells_id', '=', $spell->id)
                ->get();
        }

        return response()->json($spells, 201);
    }

    // POST
    public function addSpell(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:spells|max:255',
            'school_of_magic' => 'string|max:255|nullable',
            'area' => 'string|max:255|nullable',
            'casting_time' => 'string|max:255|nullable',
            'components' => 'string|max:255|nullable',
            'duration' => 'string|max:255|nullable',
            'levels' => 'required',
            'levels.*.level' => 'numeric|max:255|nullable',
            'levels.*.class' => 'string|max:255|nullable',
            'effect' => 'string|max:255|nullable',
            'range' => 'string|max:255|nullable',
            'saving_throw' => 'string|max:255|nullable',
            'spell_resistance' => 'string|max:255|nullable',
            'summary' => 'required|string|max:5000|nullable',
            'target' => 'string|max:255|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $spell = Spell::create([
            'name' => $request->get('name'),
            'school_of_magic' => $request->get('school_of_magic'),
            'area' => $request->get('area'),
            'casting_time' => $request->get('casting_time'),
            'components' => $request->get('components'),
            'duration' => $request->get('duration'),
            'effect' => $request->get('effect'),
            'range' => $request->get('range'),
            'saving_throw' => $request->get('saving_throw'),
            'spell_resistance' => $request->get('spell_resistance'),
            'target' => $request->get('target'),
            'summary' => $request->get('summary'),
        ]);

        foreach ($request->get('levels') as $level) {
            SpellLevel::create([
                'spells_id' => $spell->id,
                'level' => $level['level'],
                'class' => $level['class'],
            ]);
        }

        return response()->json(201);
    }

    // PUT

    public function updateSpell()
    {

        // $data = $request->all();

        // $validator = Validator::make($data['data'], [
        //     '*.name' => 'required|string',
        //     '*.attack_bonus' => 'required|numeric',
        //     '*.damage' => 'required|string',
        //     '*.critical' => 'required|string',
        //     '*.range' => 'required|numeric',
        //     '*.type' => 'required|string',
        //     '*.ammo' => 'required|numeric',
        //     '*.equipped' => 'required|boolean',
        //     '*.order' => 'required|numeric',
        //     '*.notes' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $user = JWTAuth::parseToken()->authenticate();
        // $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        // if (!$character) {
        //     return response()->json(['message' => 'Invalid Character!'], 401);
        // }

        // foreach ($data['data'] as $weapon) {
        //     Weapon::whereId($weapon['id'])
        //         ->where('character_id', '=', $character->id)
        //         ->update([
        //             'name' => $weapon['name'],
        //             'attack_bonus' => $weapon['attack_bonus'],
        //             'damage' => $weapon['damage'],
        //             'critical' => $weapon['critical'],
        //             'range' => $weapon['range'],
        //             'type' => $weapon['type'],
        //             'ammo' => $weapon['ammo'],
        //             'equipped' => $weapon['equipped'],
        //             'order' => $weapon['order'],
        //             'notes' => $weapon['notes'],
        //         ]);
        // }

        return response()->json(201);
    }

    // DELETE

    public function deleteSpell()
    {
        // $data = $request->all();

        // $validator = Validator::make($data, [
        //     'character_id' => 'required|numeric',
        //     'weapon_id' => 'required|numeric',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $user = JWTAuth::parseToken()->authenticate();
        // $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        // if (!$character) {
        //     return response()->json(['message' => 'Invalid Character!'], 401);
        // }

        // Weapon::whereId($data['weapon_id'])
        //     ->where('character_id', '=', $character->id)
        //     ->delete();

        return response()->json(201);
    }
}
