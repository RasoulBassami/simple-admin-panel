<?php

namespace App\Http\Controllers;

use App\User;
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

    public function login(Request $request)
    {
        $input = $request->validate([
           'username' => ['required', 'string', 'exists:users,username'],
           'password' => ['required', 'string']
        ]);

        $credentials = array(
            'username' => $input['username'],
            'password' => $input['password']
        );
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect($this->redirectPath());
        }

        return redirect(route('login'))->with('error','Username And Password Are Wrong.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectPath()
    {

        if (auth()->user()->isAdmin()) {
            return route('admin.dashboard');
        }
        return route('dashboard');
    }
}
