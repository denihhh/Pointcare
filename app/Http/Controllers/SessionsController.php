<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'=>['string','email','max:255','required'],
            'password'=>['string', 'max:255','min:8','required']
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['password'=>'We were unable to authenticate you with the provided credentials.'])
                ->withInput();

        }

        $request->session()->regenerate();
        return redirect()->intended('/')->with('success','Logged in successfully');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/')->with('success','Logged out successfully');
    }
}
