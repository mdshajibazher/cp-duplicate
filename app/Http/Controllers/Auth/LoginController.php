<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    //For Google
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallBack(){
        $user =  Socialite::driver('google')->user();
        $this->_registerOrLoingUser($user,'google');
        return redirect()->route('checkoutpage.index');
    }

    //For Facebook
    public function redirectToFacebook(){
        Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallBack(){
        $user =  Socialite::driver('facebook')->user();
        $this-> _registerOrLoingUser($user,'facebook');
        return redirect()->route('checkoutpage.index');
    }

    protected function _registerOrLoingUser($data,$provider){
        $user = User::updateOrCreate([
            'email' => $data->email,
        ], [
            'name' => $data->name,
            'user_type' => 'ecom',
            'email' => $data->email,
            'provider' => $provider,
            'division_id' => 6,
            'section_id' => 3,
            'image' => $data->avatar,
        ]);
        Auth::login($user);
    }


}
