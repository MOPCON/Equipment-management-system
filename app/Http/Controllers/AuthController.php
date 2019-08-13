<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiTrait;

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

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return $this->returnSuccess('密碼更改成功');
        }

        return $this->return400Response('密碼錯誤');
    }
}
