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
use App\BaseAttack;
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

class CharacterController extends Controller
{
    //  GET 
    public function getById($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $character = Character::select()->where('id', '=', $id)->where("user_id", "=", $user->id)->first();

        if (empty($character)) {
            return new CharacterResource(null);
        }

        $note_section = (NoteSection::select('id', 'name', 'order')
            ->where('character_id', '=', $id)
            ->get());

        foreach ($note_section as $section) {
            $section->note = (Note::select('id', 'name', 'summary', 'order')
                ->where('note_sections_id', '=', $section['id'])
                ->get());
        }

        $character->note_section = $note_section;

        $character->saving_throws = (CharacterSavingThrow::select(
            'character_saving_throws.id',
            'character_saving_throws.name',
            'character_abilities.score AS ability_score',
            'character_abilities.temp_score AS ability_temp_score',
            'character_saving_throws.base_score',
            'character_saving_throws.magic_score',
            'character_saving_throws.misc_score',
            'character_saving_throws.temp_score'
        )
            ->join('character_abilities', 'character_abilities.id', '=', 'character_saving_throws.character_ability_id')
            ->where('character_saving_throws.character_id', '=', $id)
            ->get());

        $character->armor = (Armor::select(
            'id',
            'name',
            'ac_bonus',
            'check_penalty',
            'type',
            'max_dex',
            'spell_failure',
            'speed',
            'weight',
            'equipped',
            'order',
            'notes'
        )
            ->where('character_id', '=', $id)
            ->get());

        $character->weapons = (Weapon::select(
            'id',
            'name',
            'attack_bonus',
            'damage',
            'critical',
            'range',
            'type',
            'ammo',
            'equipped',
            'order',
            'notes'
        )
            ->where('character_id', '=', $id)
            ->get());

        $character->armor_class = (ArmorClass::select(
            'armor_classes.id',
            'character_abilities.score',
            'character_abilities.temp_score',
            'armor_classes.armor_bonus',
            'armor_classes.size_bonus',
            'armor_classes.natural_bonus',
            'armor_classes.misc_bonus'
        )
            ->join('character_abilities', 'character_abilities.id', '=', 'armor_classes.character_ability_id')
            ->where('armor_classes.character_id', '=', $id)
            ->get());


        $character->base_attacks = (BaseAttack::select(
            'id',
            'base_bonus',
            'second_bonus',
            'third_bonus',
            'fourth_bonus',
        )->where('character_id', '=', $id)->get());

        $character->grapple = (Grapple::select(
            'grapples.id',
            'character_abilities.score',
            'character_abilities.temp_score',
            'grapples.size_bonus',
            'grapples.misc_bonus',
        )
            ->join('character_abilities', 'character_abilities.id', '=', 'grapples.character_ability_id')
            ->where('grapples.character_id', '=', $id)
            ->get());

        $character->health_points = (HealthPoint::select(
            'id',
            'total_hp',
            'damage',
            'non_lethal',
            'temp_hp'
        )
            ->where('character_id', '=', $id)
            ->get());

        $character->initiative = (Initiative::select(
            'initiatives.id',
            'character_abilities.score',
            'character_abilities.temp_score',
            'initiatives.misc_bonus'
        )
            ->join('character_abilities', 'character_abilities.id', '=', 'initiatives.character_ability_id')
            ->where('initiatives.character_id', '=', $id)
            ->get());

        $character->skills = (CharacterSkill::select(
            'character_skills.id',
            'character_skills.name',
            'abilities.id AS ability_id',
            'abilities.code',
            'character_abilities.score',
            'character_abilities.temp_score',
            'character_skills.rank_score',
            'character_skills.misc_score',
            'character_skills.order',
            'character_skills.class_skill',
            'character_skills.untrained_skill'
        )
            ->join('character_abilities', 'character_abilities.id', '=', 'character_skills.character_ability_id')
            ->join('abilities', 'abilities.id', '=', 'character_abilities.ability_id')
            ->where('character_skills.character_id', '=', $id)
            ->orderBy('character_skills.order', 'ASC')
            ->orderBy('character_skills.name', 'ASC')
            ->get());

        $character->abilities = (CharacterAbility::select(
            'character_abilities.id',
            'abilities.name',
            'character_abilities.score',
            'character_abilities.temp_score',
        )
            ->join('abilities', 'abilities.id', '=', 'character_abilities.ability_id')
            ->where('character_abilities.character_id', '=', $id)
            ->get());

        return new CharacterResource($character);
    }

    public function all()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $characters = Character::select('name', 'id')->where("user_id", "=", $user->id)->get();

        if (empty($characters)) {
            return new CharacterResource(null);
        }

        return  new CharacterResource($characters);
    }

    //  POST 
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|max:255',
            'name' => 'required|string|max:255',
            'race' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'alignment' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $character = Character::create([
            'user_id' => $request->get('user_id'),
            'name' => $request->get('name'),
            'race' => $request->get('race'),
            'class' => $request->get('class'),
            'alignment' => $request->get('alignment'),
            'gender' => $request->get('gender'),
        ]);

        $abilities = Ability::select()->get();

        $dex = Ability::select()->where('code', '=', 'DEX')->first();
        $str = Ability::select()->where('code', '=', 'STR')->first();

        foreach ($abilities as $ability) {
            CharacterAbility::create([
                'character_id' => $character->id,
                'ability_id' => $ability->id,
            ]);
        }

        $saving_throws = SavingThrow::select()->get();

        foreach ($saving_throws as $saving_throw) {
            CharacterSavingThrow::create([
                'name' => $saving_throw->name,
                'character_id' => $character->id,
                'character_ability_id' => $saving_throw->ability_id,
            ]);
        }

        $skills = Skill::select()->get();

        foreach ($skills as $skill) {
            CharacterSkill::create([
                'character_id' => $character->id,
                'character_ability_id' => $skill->ability_id,
                'name' => $skill->name,
                'untrained_skill' => $skill->untrained_skill,
            ]);
        }

        ArmorClass::create([
            'character_id' => $character->id,
            'character_ability_id' =>  $dex->id,
        ]);

        BaseAttack::create([
            'character_id' => $character->id,
        ]);

        Grapple::create([
            'character_id' => $character->id,
            'character_ability_id' =>  $str->id,
        ]);

        HealthPoint::create([
            'character_id' => $character->id,
        ]);

        Initiative::create([
            'character_id' => $character->id,
            'character_ability_id' =>  $dex->id,
        ]);

        return response()->json(compact('character'), 201);
    }

    // PUT 
    public function updateAbilities(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data['data'], [
            '*.score' => 'required|numeric',
            '*.temp_score' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        foreach ($data['data'] as $ability) {
            CharacterAbility::whereId($ability['id'])
                ->where('character_id', '=', $data['character_id'])
                ->update([
                    'score' => $ability['score'],
                    'temp_score' => $ability['temp_score'],
                ]);
        }

        return response()->json(201);
    }

    public function updateSummary(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data['data'], [
            'name' => 'required|string',
            'race' => 'required|string',
            'class' => 'required|string',
            'alignment' => 'required|string',
            'gender' => 'required|string',
            'speed' => 'required|numeric',
            'size' => 'required|string',
            'experience' => 'required|numeric',
            'prestige_class' => 'string|nullable',
            'prestige_experience' => 'numeric|nullable',
            'multi_class' => 'string|nullable',
            'multi_experience' => 'numeric|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        Character::whereId($user->id)
            ->update([
                'name' => $data['data']['name'],
                'race' => $data['data']['race'],
                'class' => $data['data']['class'],
                'alignment' => $data['data']['alignment'],
                'experience' => $data['data']['experience'],
                'gender' => $data['data']['gender'],
                'speed' => $data['data']['speed'],
                'size' => $data['data']['size'],
                'prestige_class' => $data['data']['prestige_class'],
                'prestige_experience' => $data['data']['prestige_experience'],
                'multi_class' => $data['data']['multi_class'],
                'multi_experience' => $data['data']['multi_experience'],
            ]);

        return response()->json(201);
    }

    public function updateSavingThrows(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data['data'], [
            '*.base_score' => 'required|numeric',
            '*.magic_score' => 'required|numeric',
            '*.misc_score' => 'required|numeric',
            '*.temp_score' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        foreach ($data['data'] as $savingThrow) {
            CharacterSavingThrow::whereId($savingThrow['id'])
                ->where('character_id', '=', $data['character_id'])
                ->update([
                    'base_score' => $savingThrow['base_score'],
                    'magic_score' => $savingThrow['magic_score'],
                    'misc_score' => $savingThrow['misc_score'],
                    'temp_score' => $savingThrow['temp_score'],
                ]);
        }

        return response()->json(201);
    }

    public function updateHP(Request $request)
    {
        $characterId = $request->all()['character_id'];
        $healthPoints = $request->all()['data'];

        $validator = Validator::make($healthPoints, [
            'damage' => 'required|numeric',
            'non_lethal' => 'required|numeric',
            'temp_hp' => 'required|numeric',
            'total_hp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($characterId)->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        HealthPoint::whereId($healthPoints['id'])
            ->where('character_id', '=', $characterId)
            ->update([
                'damage' => $healthPoints['damage'],
                'non_lethal' => $healthPoints['non_lethal'],
                'temp_hp' => $healthPoints['temp_hp'],
                'total_hp' => $healthPoints['total_hp'],
            ]);

        return response()->json(201);
    }

    public function updateAC(Request $request)
    {
        $characterId = $request->all()['character_id'];
        $armorClass = $request->all()['data'];

        $validator = Validator::make($armorClass, [
            'armor_bonus' => 'required|numeric',
            'natural_bonus' => 'required|numeric',
            'size_bonus' => 'required|numeric',
            'misc_bonus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($characterId)->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        ArmorClass::whereId($armorClass['id'])
            ->where('character_id', '=', $characterId)
            ->update([
                'armor_bonus' => $armorClass['armor_bonus'],
                'natural_bonus' => $armorClass['natural_bonus'],
                'size_bonus' => $armorClass['size_bonus'],
                'misc_bonus' => $armorClass['misc_bonus'],
            ]);

        return response()->json(201);
    }

    public function updateGrapple(Request $request)
    {
        $characterId = $request->all()['character_id'];
        $grapple = $request->all()['data'];

        $validator = Validator::make($grapple, [
            'size_bonus' => 'required|numeric',
            'misc_bonus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($characterId)->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        Grapple::whereId($grapple['id'])
            ->where('character_id', '=', $characterId)
            ->update([
                'size_bonus' => $grapple['size_bonus'],
                'misc_bonus' => $grapple['misc_bonus'],
            ]);

        return response()->json(201);
    }

    public function updateBaseAttack(Request $request)
    {
        $characterId = $request->all()['character_id'];
        $baseAttack = $request->all()['data'];

        $validator = Validator::make($baseAttack, [
            'base_bonus' => 'required|numeric',
            'second_bonus' => 'numeric|nullable',
            'third_bonus' => 'numeric|nullable',
            'fourth_bonus' => 'numeric|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($characterId)->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        BaseAttack::whereId($baseAttack['id'])
            ->where('character_id', '=', $characterId)
            ->update([
                'base_bonus' => $baseAttack['base_bonus'],
                'second_bonus' => $baseAttack['second_bonus'],
                'third_bonus' => $baseAttack['third_bonus'],
                'fourth_bonus' => $baseAttack['fourth_bonus'],
            ]);

        return response()->json(201);
    }

    public function updateInitiative(Request $request)
    {
        $characterId = $request->all()['character_id'];
        $initiative = $request->all()['data'];

        $validator = Validator::make($initiative, [
            'misc_bonus' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $character = Character::whereId($characterId)->where('user_id', '=', $user->id)->first();

        if (!$character) {
            return response()->json(['message' => 'Invalid Character!'], 401);
        }

        Initiative::whereId($initiative['id'])
            ->where('character_id', '=', $characterId)
            ->update([
                'misc_bonus' => $initiative['misc_bonus'],
            ]);

        return response()->json(201);
    }

    // DELETE

}
