<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // Send user to registration form
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Check data
        // Sign user in
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();

            // Redirect user to dashboard after successful login
            return redirect()->intended('dashboard');
        }

        // Redirect user if credentials are wrong
        return back()->with('status', 'Invalid login details');
    }
}
