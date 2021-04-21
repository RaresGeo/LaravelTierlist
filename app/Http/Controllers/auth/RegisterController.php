<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        // Send user to registration form
        return view('auth.register');
    }

    public function store(Request $request)
    {

        // Validate data
        $this->validate($request, [
            'name' => 'required|max:255|unique:App\Models\User,name',
            'email' => 'required|email|max:255|unique:App\Models\User,email',
            'password' => 'required|confirmed',
        ]);

        // Store data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Maybe send email


        // Sign user in
        if (Auth::attempt($request->only('email', 'password'))) {
            //$request->session()->regenerate();

            // Redirect user to dashboard after successful login
            return redirect()->intended('dashboard');
        }

        return back()->with('status', 'Something went wrong');
    }
}
