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
    public function login(Request $request) {
        try {
            // Start the session
            $request->session();
    
            // Set a session variable
            session(['test_session' => 'Session is working']);
    
            // Retrieve the session variable to check if it was stored
            $testSession = session('test_session');
    
            // Log the session value to verify it
            \Log::info('Test Session Value: ' . $testSession);
    
            // Log the action in the custom Log model
            Log::create([
                'message' => 'Test Session Value: ' . $testSession,
                'level' => 'info',
                'type' => 'checking',
            ]);
    
            // Define different cookie configurations
            $cookies = [
                'standard_cookie' => cookie('standard_cookie', 'Standard Cookie', 60),
                'secure_cookie' => cookie('secure_cookie', 'Secure Cookie', 60, null, null, true, true),
                'http_only_cookie' => cookie('http_only_cookie', 'HttpOnly Cookie', 60, null, null, false, true),
                'same_site_lax_cookie' => cookie('same_site_lax_cookie', 'SameSite Lax Cookie', 60, null, null, true, true, false, 'lax'),
                'same_site_strict_cookie' => cookie('same_site_strict_cookie', 'SameSite Strict Cookie', 60, null, null, true, true, false, 'strict'),
                'same_site_none_cookie' => cookie('same_site_none_cookie', 'SameSite None Cookie', 60, null, null, true, true, false, 'none'),
            ];
    
            // Log each cookie setting action
            foreach ($cookies as $name => $cookie) {
                \Log::info("Setting Cookie - $name: " . $cookie->getValue());
                Log::create([
                    'message' => "Setting Cookie - $name: " . $cookie->getValue(),
                    'level' => 'info',
                    'type' => 'checking',
                ]);
            }
    
            // Attach all cookies to the response
            $response = response()
                ->view('auth.login', ['testSession' => $testSession]);
    
            foreach ($cookies as $cookie) {
                $response->cookie($cookie);
            }
    
            return $response;
    
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Session or Cookie Error: ' . $e->getMessage());
    
            // Log the error action in the custom Log model
            Log::create([
                'message' => 'Session or Cookie Error: ' . $e->getMessage(),
                'level' => 'error',
                'type' => 'checking',
            ]);
    
            // Optionally, handle the error by displaying a message to the user or redirecting them
            return view('auth.login', ['error' => 'An error occurred while processing your request.']);
        }
    }
    public function showLoginForm(Request $request) {
        // Define the names of the cookies to retrieve
        $cookieNames = [
            'standard_cookie',
            'secure_cookie',
            'http_only_cookie',
            'same_site_lax_cookie',
            'same_site_strict_cookie',
            'same_site_none_cookie',
        ];
    
        // Retrieve and log the cookie values
        $cookieValues = [];
        foreach ($cookieNames as $name) {
            $cookieValues[$name] = $request->cookie($name);
            \Log::info("Test Cookie Value - $name: " . $cookieValues[$name]);
            Log::create([
                'message' => "Test Cookie Value - $name: " . $cookieValues[$name],
                'level' => 'info',
                'type' => 'checking',
            ]);
        }
    
        // Pass the cookie values to the view for display
        return view('auth.login', ['cookieValues' => $cookieValues]);
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