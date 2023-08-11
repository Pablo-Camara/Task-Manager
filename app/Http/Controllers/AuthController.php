<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login () {
        return view('home', [
            'view' => 'Login',
            'loginNotice' => 'Please login to continue',
            'formBtnTxt' => 'Login'
        ]);
    }

    public function loginAttempt (Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', '=', $username)->first();
        if (empty($user) || !Hash::check($password, $user->password)) {
            //@TODO: translation
            $authErrorMsg = 'Wrong password and / or username.';

            return view('home', [
                'view' => 'Login',
                'authErrorMsg' => $authErrorMsg
            ]);
        }

        Auth::login($user);
        return redirect()->route('home');
    }

    public function register () {
        return view('home', [
            'view' => 'Register',
            'loginNotice' => 'Create your username and password',
            'formBtnTxt' => 'Create my account'
        ]);
    }
}
