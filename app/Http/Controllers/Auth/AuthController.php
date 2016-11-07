<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Repositories\FacebookRepository;

class AuthController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    protected $facebookRepository;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(FacebookRepository $facebookRepository)
    {
        $this->facebookRepository = $facebookRepository;
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'loginByFacebook', 'connectToFacebook']]);
    }

    /**
     *  Set page title
     * @param type $method
     * @param type $parameters
     * @return type
     */
    public function callAction($method, $parameters)
    {
        switch ($method) {
            // set title for register page
            case 'getRegister':
                view()->share('pageTitle', 'Sign Up');
                break;
            case 'getLogin':
                view()->share('pageTitle', 'Sign In');
                break;
        }
        return parent::callAction($method, $parameters);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    public function loginByFacebook()
    {
        $loginUrl = $this->facebookRepository->getAuthorizationUri(['email']);
        return redirect($loginUrl);
    }

    public function connectToFacebook()
    {
        try {
            $user = $this->facebookRepository->connect();
            auth()->guard()->login($user);
            return redirect('/home');
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return redirect('/login')->withErrors(['error' => $e->getMessage()]);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return redirect('/login')->withErrors(['error' => $e->getMessage()]);
        } catch (\App\Exceptions\BadRequestHttpException $e) {
            return redirect('/login')->withErrors(['error' => 'Please accept permission for access your account']);
        }
    }

}
