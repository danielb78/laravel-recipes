<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function getFacebookCallback()
    {
        $data =  Socialite::with('facebook')->user();
        $user = User::where('email', $data->email)->first();

        if(!is_null($user)) {
            Auth::login($user);

            $user->name = $data->user['name'];
            $user->facebook_id = $data->id;
            $user->save();
        } else {
            $user = User::where('facebook_id', $data->id)->first();

            if(is_null($user)) {
                $user = new User();
                $user->name = $data->user['name'];
                $user->facebook_id = $data->id;
                $user->email = $data->email;
                $user->password = Hash::make(str_random(8));

                $user->save();
            }

            Auth::login($user);
        }

        return redirect('/')->with('status', 'Successfully logged in');
    }
}
