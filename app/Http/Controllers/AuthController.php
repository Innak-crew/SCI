<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class AuthController extends Controller
{
    public function login (){
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        // Log the logout action
        Log::create([
            'message' => 'User ' . Auth::user()->email . ' logged out.',
            'level' => 'info'
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Attempt authentication
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::create([
                'message' => 'User ' . Auth::user()->email . ' logged in.',
                'level' => 'info'
            ]);

            // Redirect based on user role
            if (Auth::user()->role == 'admin') {
                return redirect()->intended(route('admin.index'));
            } else {
                return redirect()->intended(route('manager.index'));
            }
        }

        // Authentication failed
        $user = User::where('email', $request->email)->first();
        if ($user) {
            // Incorrect password
            if (!Hash::check($request->password, $user->password)) {
                Log::create([
                    'message' => 'Failed login attempt with email: ' . $request->email . ' due to incorrect password.',
                    'level' => 'warning'
                ]);
                return back()->withErrors([
                    'password' => 'The provided password is incorrect.',
                ])->withInput();
            }
        } else {
            // Email not found
            Log::create([
                'message' => 'Failed login attempt with non-existent email: ' . $request->email,
                'level' => 'warning'
            ]);
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }

        Log::create([
            'message' => 'Failed login attempt with email: ' . $request->email,
            'level' => 'warning'
        ]);
    
        // Authentication failed due to incorrect credentials
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }       
}