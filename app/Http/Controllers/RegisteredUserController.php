<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(Request $request){
        $attributes = $request->validate([
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:2'],
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required', 'confirmed', Password::min(6)->letters()->numbers()],
        ]);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect("/jobs");

    }
}
