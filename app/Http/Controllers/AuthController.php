<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $remember = $request->input('remember', false);
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect('/');
        }

        return back()->withInput()->with('error', '帳號或密碼錯誤');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
