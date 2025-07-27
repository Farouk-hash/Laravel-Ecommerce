<?php

namespace App\Http\Controllers;

use App\Events\UserSubcriber;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function signupform(Request $request){
        // Check if there's a specific URL to redirect back to
        if ($request->has('redirect')) {
            session(['url.intended' => $request->get('redirect')]);
        }
        return view('Application.auth.signup');
    }
    public function loginform(Request $request){
        // Check if there's a specific URL to redirect back to
        if ($request->has('redirect')) {
            session(['url.intended' => $request->get('redirect')]);
        }
        return view('Application.auth.login');
    }

    public function signup(Request $request){
        $validate = $request->validate([
        'name' => ['required', 'string', 'unique:users,name'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => [
            'required',
            'confirmed',
            Password::min(8)->mixedCase()->symbols()->numbers()
        ],
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), // password will be hashed through User::Model Via Casts()'password' => 'hashed',

        ]);

        Auth::login($user);
        // Regenerate session for security
        $request->session()->regenerate();

        event(new UserSubcriber($user));
    
        // Redirect to intended URL or default to Home
        return redirect()->intended(route('user.profile'));                
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $credentials_object = (object)$credentials ; 
            $user = User::where('email' , $credentials_object->email)->first();
            if($user->email_verified_at == null){
                event(new UserSubcriber($user));
            }
            return redirect()->intended(route('Home'));

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('Home');
    }
}
