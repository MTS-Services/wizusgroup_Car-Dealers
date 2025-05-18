<?php

namespace App\Http\Controllers\Backend\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;


    public function verify(Request $request)
    {
        $admin = $this->guard()->user();

        if (!hash_equals((string) $request->route('id'), (string) $admin->getKey())) {
            abort(403, 'This action is unauthorized.');
        }

        if (!hash_equals((string) $request->route('hash'), sha1($admin->getEmailForVerification()))) {
            abort(403, 'This action is unauthorized.');
        }

        if ($admin->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('frontend.auth.admin.verify');
    }

    /**
     * Use the admin guard.
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected function redirectTo()
    {
        return route('admin.dashboard');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
