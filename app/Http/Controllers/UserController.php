<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Displays registration page
    public function register()
    {
        return view('auth.sign-up');
    }

    //Register new user
    public function registerUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        $userData = [
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];
        
        $user = User::create($userData);

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id
        ]);

        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    //Displays the Login page
    public function login()
    {
        return view('auth.sign-in');
    }

    //Authenticates and logs in user
    public function authenticateUser(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You have been successfully logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    //Logs out user
    public function logoutUser()
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login')->with('message', 'You have been logged out');
    }

}
