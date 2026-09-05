<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Form
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Process Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Login Details
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Login Value
        |--------------------------------------------------------------------------
        */

        $loginValue = trim($validated['username']);


        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        |
        | Users can log in using:
        |
        | 1. Full Name
        | 2. Email Address
        |
        */

        $user = User::where('name', $loginValue)
            ->orWhere('email', $loginValue)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Check Whether User Exists
        |--------------------------------------------------------------------------
        */

        if (! $user) {
            return back()
                ->withInput(
                    $request->only('username')
                )
                ->withErrors([
                    'username' =>
                        'The name, email, or password is incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Check Password
        |--------------------------------------------------------------------------
        */

        if (! Hash::check(
            $validated['password'],
            $user->password
        )) {
            return back()
                ->withInput(
                    $request->only('username')
                )
                ->withErrors([
                    'username' =>
                        'The name, email, or password is incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Log User In
        |--------------------------------------------------------------------------
        |
        | No is_active check because the users table
        | does not contain an is_active column.
        |
        */

        Auth::login(
            $user,
            $request->boolean('remember')
        );


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Redirect To Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()->route('dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Password Confirmation Form
    |--------------------------------------------------------------------------
    */

    public function showConfirmPasswordForm()
    {
        return view('auth.confirm-password');
    }


    /*
    |--------------------------------------------------------------------------
    | Confirm Current Password
    |--------------------------------------------------------------------------
    */

    public function confirmPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
            ],
        ]);

        $user = Auth::user();

        if (
            ! $user ||
            ! Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'password' =>
                        'The password you entered is incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Remember Password Confirmation
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'password_confirmed_at',
            now()->timestamp
        );


        return redirect()->intended(
            route('dashboard')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Change Password Form
    |--------------------------------------------------------------------------
    */

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }


    /*
    |--------------------------------------------------------------------------
    | Change Current User Password
    |--------------------------------------------------------------------------
    */

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Check Current Password
        |--------------------------------------------------------------------------
        */

        if (
            ! $user ||
            ! Hash::check(
                $validated['current_password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Your current password is incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        $user->update([
            'password' => Hash::make(
                $validated['password']
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Clear Previous Password Confirmation
        |--------------------------------------------------------------------------
        */

        $request->session()->forget(
            'password_confirmed_at'
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your password has been changed successfully.'
            );
    }
}