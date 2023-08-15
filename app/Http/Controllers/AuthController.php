<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login () {
        return view('home', $this->loginViewData());
    }

    public function loginAttempt (Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', '=', $username)->first();
        if (empty($user) || !Hash::check($password, $user->password)) {
            //@TODO: translation
            $authErrorMsg = 'Wrong password and / or username.';

            return view('home', array_merge(
                $this->loginViewData(),
                [
                    'authErrorMsg' => $authErrorMsg
                ]
            ));
        }

        Auth::login($user);
        return redirect()->route('home');
    }

    public function logoutAttempt () {
        Auth::logout();
    }

    private function loginViewData() {
        return [
            'view' => 'Login',
            'loginNotice' => 'Please login to continue',
            'formBtnTxt' => 'Login',
            'formAction' => route('loginAttempt')
        ];
    }

    private function registerViewData() {
        return [
            'view' => 'Register',
            'loginNotice' => 'Create your username and password',
            'formBtnTxt' => 'Create my account',
            'formAction' => route('registerAttempt')
        ];
    }
    public function register () {
        return view('home', $this->registerViewData());
    }

    public function registerAttempt (Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        //@TODO: use validator in the future
        if (empty(trim($username))) {
            //@TODO: translation
            $authErrorMsg = 'Must create an username.';

            return view('home', array_merge(
                $this->registerViewData(),
                [
                    'authErrorMsg' => $authErrorMsg
                ]
            ));
        }

        if (empty(trim($password))) {
            //@TODO: translation
            $authErrorMsg = 'Must create a password.';

            return view('home', array_merge(
                $this->registerViewData(),
                [
                    'authErrorMsg' => $authErrorMsg
                ]
            ));
        }

        $user = User::where('username', '=', $username)->first();
        if (!empty($user)) {
            //@TODO: translation
            $authErrorMsg = 'Username already in use.';

            return view('home', array_merge(
                $this->registerViewData(),
                [
                    'authErrorMsg' => $authErrorMsg
                ]
            ));
        }

        $newUser = new User([
            'username' => $username,
            'password' => Hash::make($password)
        ]);
        $newUser->save();

        Auth::login($newUser);
        return redirect()->route('home');
    }
}
