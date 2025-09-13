<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {

            $socialiteUser = Socialite::driver('google')->stateless()->user();
     
        } catch (ClientException $e) {

            return response()->error('Invalid credentials provided');
        }

        $user = User::firstWhere("email", $socialiteUser->getEmail());

        if (!isset($user->id)) {

            $user = new User();

            $user->email = $socialiteUser->getEmail();

            $user->save();
        }

        $token = $user->createToken($user->id);

        $token = $token->plainTextToken;

        return view("google", compact("token"));

    }
}
