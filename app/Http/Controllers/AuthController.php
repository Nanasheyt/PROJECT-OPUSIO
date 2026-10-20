<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /** Letters, spaces and the punctuation found in names (. , ' - and accents). No digits. */
    public const LETTERS = '/^[\pL\s.,\'’\-]+$/u';

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = ['email' => strtolower(trim($data['email'])), 'password' => $data['password']];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'The email or password is incorrect.']);
        }

        $request->session()->regenerate(); // protects against session fixation

        // After logging in, always land on the home page
        $request->session()->forget('url.intended');

        return redirect()->route('home');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:' . self::LETTERS],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ], [
            'name.regex'   => 'The name may only contain letters, spaces and . , \' -',
            'email.unique' => 'An account with this email already exists. Try logging in instead.',
        ], ['name' => 'name', 'email' => 'email', 'password' => 'password']);

        $user = User::create([
            'name'     => trim($data['name']),
            'email'    => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Welcome to Opusio, ' . strtok($user->name, ' ') . '! Your account is ready.');
    }

    /* ------------------------------------------------------------------
     |  Forgot / reset password
     * -----------------------------------------------------------------*/

    public function showForgot(): View
    {
        return view('auth.forgot-password');
    }

    /** Email a one-hour reset link. The answer is the same whether or not the email has an account. */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email']]);

        try {
            $status = Password::sendResetLink(['email' => strtolower(trim($data['email']))]);
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()
                ->withErrors(['email' => 'We could not send the email right now. Please try again in a moment.']);
        }

        if ($status === Password::RESET_THROTTLED) {
            return back()->withInput()
                ->withErrors(['email' => 'Please wait a minute before asking for another link.']);
        }

        return back()->with('success', 'If an account exists for that email, a password reset link is on its way. Check your inbox and spam folder. The link works for 60 minutes.');
    }

    public function showReset(Request $request, string $token): View
    {
        return view('auth.reset-password', ['token' => $token, 'email' => (string) $request->query('email', '')]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token'    => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        $status = Password::reset(
            [
                'email'                 => strtolower(trim($data['email'])),
                'password'              => $data['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token'                 => $data['token'],
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60), // signs the account out of any "keep me logged in" devices
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Your password was changed. You can now log in with the new password.');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'This reset link is invalid or has expired. Please request a new one.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
