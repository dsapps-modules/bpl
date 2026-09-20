<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $email = $request->string('email')->toString();
        $user = User::query()->where('email', $email)->first();

        if ($user === null) {
            return back()
                ->withErrors(['email' => __('passwords.user')])
                ->withInput();
        }

        if (app()->isLocal()) {
            $token = Password::broker()->createToken($user);
            $user->sendPasswordResetNotification($token);

            return back()
                ->with('status', __('passwords.sent'))
                ->with('password_reset_url', URL::route('password.reset', [
                    'token' => $token,
                    'email' => $user->email,
                ]));
        }

        $status = Password::sendResetLink(['email' => $email]);

        return back()->with('status', __($status));
    }
}
