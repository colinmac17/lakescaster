<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreate($user, $provider);
        if($authUser) {
            Auth::login($authUser, true);
        }
        return redirect($this->redirectTo)->with('loginFail', 'Sorry That Email is already taken!');
    }

    public function findOrCreate($user, $provider)
    {
        $otherUser = User::where('email', '=', $user->email)->first();
        if ($otherUser !== null && is_null($otherUser->provider_id) && is_null($otherUser->provider)) {
            // user exists and signed up with normal email
            return false;
        } else if ($otherUser !== null && !is_null($otherUser->provider_id)){
            //user account was deleted so let them back in
            $otherUser->status = 1;
            $otherUser->save();
            return $otherUser;
        }  else {
            //new user!
            $authUser = User::where('provider_id', $user->id)->first();
            if ($authUser) {
                return $authUser;
            }
            return User::create([
                'name' => $user->name,
                'email' => $user->email,
                'provider' => strtoupper($provider),
                'provider_id' => $user->id
            ]);
        }
    }
}
