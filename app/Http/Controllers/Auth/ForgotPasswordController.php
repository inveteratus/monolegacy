<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request): RedirectResponse
    {
        Password::SendResetLink($request->only('email'));

        return back()
            ->with('status', 'A password reset link has been emailed to you.')
            ->withInput($request->only('email'));
    }
}
