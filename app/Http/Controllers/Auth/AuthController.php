<?php

namespace Matchappen\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Matchappen\Http\Requests\StoreWorkplaceRequest;
use Matchappen\User;
use Matchappen\Workplace;
use Validator;
use Matchappen\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $fields_to_trim = array_merge(
            ['user.name', 'user.email', 'user.phone'],
            array_map(function ($value) {
                return 'workplace.' . $value;
            }, array_keys(StoreWorkplaceRequest::rulesForCreate()))
        );
        $this->middleware('input.trim:' . implode(',', $fields_to_trim), ['only' => 'postRegister']);
    }

    //TODO: make postRegister() redirect to getLogin() withInput if the email exists
    //TODO: make postRegister() redirect to getLogin() withInput if user has triggered login action
    //TODO: if organization name is taken in postRegister(), link to the organisation for contact details

    //TODO: make postLogin() redirect to getRegister() withInput if user has triggered register action
    //TODO: make postLogin() redirect to Auth\PasswordController@getEmail withInput if user has triggered forgotten password action
    //TODO: make postLogin() redirect to Auth\EmailTokenController@getEmail withInput if login failed and email matches supervisor email pattern

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, []);
        foreach (User::rulesForCreate() as $attribute => $rules) {
            $validator->mergeRules('user.' . $attribute, $rules);
        }
        foreach (StoreWorkplaceRequest::rulesForCreate() as $attribute => $rules) {
            $validator->mergeRules('workplace.' . $attribute, $rules);
        }

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $workplace = Workplace::create(array_filter($data['workplace']));

        $user_data = array_filter($data['user']);
        $user_data['password'] = bcrypt($user_data['password']);

        $user = new User($user_data);
        $user->workplace()->associate($workplace);
        $user->save();

        //TODO: catch occupations, add new ones, and sync them with the workplace

        //TODO: email admin after new workplace registration

        return $user;
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return action('Auth\AuthController@getLogin');
    }

    /**
     * @return string url for redirect after successful login or registration
     */
    public function redirectPath()
    {
        return route('dashboard');
    }

}
