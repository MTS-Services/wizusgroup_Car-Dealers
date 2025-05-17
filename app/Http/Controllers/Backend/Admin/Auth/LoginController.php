<?php

namespace App\Http\Controllers\Backend\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use App\Rules\Admin\ValidPassword;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

   use AuthenticatesUsers;

    /**
     * Where to redirect after login.
     */
    protected function redirectTo()
    {
        return route('admin.dashboard');
    }

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('frontend.auth.admin.login');
    }

    /**
     * Username field (can be email or username).
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Guard for admin.
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Override credentials to allow login via email or username.
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

    /**
     * Custom validation with email/username detection.
     */
    protected function validateLogin(Request $request)
    {
        $login = $request->input('login');
        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

        $request->validate([
            'login' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($isEmail) {
                    $field = $isEmail ? 'email' : 'username';
                    if (!Admin::where($field, $value)->exists()) {
                        $fail("The selected {$attribute} is invalid.");
                    }
                },
            ],
            'password' => 'required|string',
        ]);
    }

    /**
     * Ensure admin is verified before login success.
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        $admin = $this->guard()->user();

        // Check if email is verified
        if (method_exists($admin, 'hasVerifiedEmail') && !$admin->hasVerifiedEmail()) {
            // Automatically send verification email
            $admin->sendEmailVerificationNotification();

            // Redirect to admin verification notice page
            return redirect()->route('admin.verification.notice')
                 ->with('resent', true);
        }

        return $this->authenticated($request, $admin)
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Logout and redirect to admin login.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
