<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        if(! is_null(auth()->user())) {
            return redirect($this->redirectPath());
        }

        return view('login');
    }

    public function login(UserRequest $request)
    {
        if ($this->attemptToLogin($request)) {
            $request->session()->regenerate();
            return redirect($this->redirectPath());
        }
        return redirect(route('login'))->with('error','نام کاربری یا رمز عبور اشتباه است');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function attemptToLogin($request)
    {
        $credentials = array(
            'username' => $request['username'],
            'password' => $request['password']
        );
        $remember = $request->has('remember');
        return Auth::attempt($credentials, $remember);
    }

    public function redirectPath()
    {
        if (auth()->user()->isAdmin()) {
            return route('admin.dashboard');
        }
        return route('dashboard');
    }
}
