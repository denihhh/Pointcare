<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>['string','min:3','max:255','required'],
            'email'=>['string','email','max:255','required', Rule::unique('users','email')],
            'password'=>['string', 'max:255','min:8','required']
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);
        Auth::login($user);
        return redirect('/')->with('success','Account created successfully');

    }

}
