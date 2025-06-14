<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;


    protected function authenticated(Request $request, $user)
    {
        if (session()->has('cart_session_id')) {
            $sessionId = Session::getId();
            $cart = Cart::where('session_id', session()->get('cart_session_id'))->first();

            DB::transaction(function () use ($sessionId, $cart, $user, $request) {
                Order::where('session_id', session()->get('cart_session_id'))
                    ->update([
                        'user_id' => $user->id,
                        'session_id' => $sessionId,
                    ]);
                if ($cart) {
                    if ($cart) {
                        $cart->update([
                            'user_id' => $user->id,
                            'session_id' => $sessionId,
                        ]);
                    }
                }
            });
            session()->put('cart_session_id', $sessionId);
            App::setLocale($user->locale);

        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        return route('user.profile');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.auth.user.login');
    }

    /**
     * Override the default username field.
     *
     * @return string
     */
    public function username()
    {
        // This tells Laravel to expect a field named "login" in the request
        return 'login';
    }

    /**
     * Override default credentials method to support email or username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('login');

        // Detect if input is an email or username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

    /**
     * Override validation to accept 'login' instead of just 'email'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * LoginController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
        $this->middleware('auth:web')->only('logout');
    }
}
