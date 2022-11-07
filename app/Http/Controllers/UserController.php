<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id
        ];
        
        $user = User::create($userData);

        // $userRole = UserRole::create([
        //     'user_id' => $user->id,
        //     'role_id' => $request->role_id
        // ]);

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

    //Dispays user details view
    public function ownProfile()
    {
        $data = [];
        $data['pageHeader'] = 'My Profile';
        $data['crumbSuffix'] = 'My Profile';
        $data['user'] = User::find(auth()->user()->id);

        return view('users.own-profile', $data);
    }

    //Dispays user details view
    public function viewUser($id)
    {
        $data = [];
        $data['pageHeader'] = 'My Profile';
        $data['crumbSuffix'] = 'My Profile';
        $data['user'] = User::find($id);

        $data['books'] = DB::table('check_outs')
        ->join('books', 'check_outs.book_id', '=', 'books.id')
        ->where('check_outs.user_id', '=', $id)
        ->where('check_outs.check_out_status', '!=', 1)
        ->get();

        return view('users.profile', $data);
    }

    //Display user profile update form
    public function updateForm()
    {
        $data = [];
        $data['pageHeader'] = 'Update Profile';
        $data['crumbSuffix'] = 'Update Profile';
        $data['user'] = User::find(auth()->user()->id);

        return view('users.profile-form', $data);
    }

    public function updateProfile(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        if ($request->hasFile('avatar')) {
            $formFields['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::where('id', auth()->user()->id)->update($formFields);

        return back()->with('message', 'Profile updated successfully');
    }

}
