<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
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

        if(auth()->attempt($credentials , $remember))
        {
            return redirect()->route('dashboard');
        }

        return redirect(route('login'))->with('error','Username And Password Are Wrong.');
    }
}
