<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param
     * @return JsonResponse
     */
    public function profile()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    /**
     * Create new user profile
     *
     * @param Request  $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $access_token = JWTAuth::fromUser($user);

        return response()->json(compact('access_token'), 201);
    }

    /**
     * Updates user profile
     *
     * @param Request  $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        if ($validator->fails() && $user->email !== $request->get('email')) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        User::whereId($user->id)->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
        ]);

        return response()->json(201);
    }

    /**
     * Updates user password
     *
     * @param Request  $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();

        User::whereId($user->id)->update([
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json(201);
    }
}
