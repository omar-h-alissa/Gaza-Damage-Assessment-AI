<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use RealRashid\SweetAlert\Facades\Alert;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        addJavascriptFile('assets/js/custom/authentication/reset-password/new-password.js');

        return view('pages.auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            Alert::error('Error', 'User not found.');
            return back();
        }
        $user->password = Hash::make($request->password);
        $user->save();

        event(new PasswordReset($user));

        Alert::success('Success', 'Your password has been reset. Please log in again.');
        return redirect()->route('login');


    }
}
