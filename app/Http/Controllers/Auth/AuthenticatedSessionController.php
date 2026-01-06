<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');

        return view('pages.auth.login');
    }


    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole(['admin', 'super-admin'])) {
            return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
        }

        return redirect()->intended(RouteServiceProvider::HOME_USER);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
