<?php

namespace App\Http\Controllers;

use App\Character;
use App\Note;
use App\NoteSection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class NoteController extends Controller
{
    // POST
    public function addNote(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'character_id' => 'required|numeric|max:255',
            'section_id' => 'required|numeric|max:255',
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($request->get('character_id'))->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        $noteSection = NoteSection::whereId($request->get('section_id'))->where('character_id', '=', $character->id)->first();

        if (!$noteSection) {
            return response()->json(['message' => 'Invalid Section!'], 401);
        }

        Note::create([
            'note_sections_id' => $request->get('section_id'),
            'summary' => 'Note Summary',
        ]);

        return response()->json(201);
    }

    public function addSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'character_id' => 'required|numeric|max:255',
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($request->get('character_id'))->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        $section = NoteSection::create([
            'character_id' => $character->id,
        ]);

        Note::create([
            'note_sections_id' => $section->id,
            'summary' => 'Note Summary',
        ]);

        return response()->json(201);
    }

    // PUT
    public function updateNoteAndSection(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data['data'], [
            '*.name' => 'required|string',
            '*.order' => 'required|numeric',
            '*.note.*.name' => 'required|string',
            '*.note.*.summary' => 'required|string',
            '*.note.*.order' => 'required|numeric',
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        foreach ($data['data'] as $noteSection) {
            NoteSection::whereId($noteSection['id'])
                ->where('character_id', '=', $character->id)
                ->update([
                    'name' => $noteSection['name'],
                    'order' => $noteSection['order'],
                ]);

            $notes = $noteSection['note'];
            foreach ($notes as $note) {
                Note::whereId($note['id'])
                    ->update([
                        'name' => $note['name'],
                        'summary' => $note['summary'],
                        'order' => $note['order'],
                    ]);
            }
        }

        return response()->json(201);
    }


    // DELETE

    public function deleteNote(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'character_id' => 'required|numeric',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        Note::whereId($data['id'])->delete();

        return response()->json(201);
    }

    public function deleteSection(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'character_id' => 'required|numeric',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) return response()->json(['message' => 'Could not authenticate!'], 401);
        $character = Character::whereId($data['character_id'])->where('user_id', '=', $user->id)->first();
        if (!$character) return response()->json(['message' => 'Invalid Character!'], 401);

        NoteSection::whereId($data['id'])
            ->where('character_id', '=', $character->id)
            ->delete();

        return response()->json(201);
    }
}
