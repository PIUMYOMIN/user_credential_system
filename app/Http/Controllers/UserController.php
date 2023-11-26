<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function user_register()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:11|max:15',
            'password'=>'required'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        Auth::login($user);

        return redirect('/admin')->with('message','Your registration is successfull');
    }

    public function user_login()
{
    $credentials = request()->only('credential', 'password');

    $user = User::where(function ($query) use ($credentials) {
        $query->where('email', $credentials['credential'])
            ->orWhere('phone', $credentials['credential']);
    })->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        // Authentication successful
        // You might set the user as authenticated here or redirect to a dashboard
        return redirect('/admin');
    }

    // Authentication failed
    // You might want to redirect back with an error message
    return redirect()->back()->withInput()->withErrors(['credential' => 'Invalid credentials']);
}


    public function logout()
    {
        auth()->logout();

        return redirect('/login');
    }
}