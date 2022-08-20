<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class LoginFacebookController extends Controller
{
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);
        // Return home after login
        return redirect()->route('home');
    }
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $name=explode(' ',$data->name);
            $user->first_name = isset($name[0])?$name[0]:null;
            $user->last_name = isset($name[1])?$name[1]:null;
            $user->email = $data->email;
            $user->facebook_id = $data->id;
            $user->email_verified_at=date('Y-m-d H:i:s');
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }
}
