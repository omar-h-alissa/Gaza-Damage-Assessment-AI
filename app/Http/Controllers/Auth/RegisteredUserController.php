<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\PalestinianID;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use RealRashid\SweetAlert\Facades\Alert;

class   RegisteredUserController extends Controller
{

    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-up/general.js');

        return view('pages.auth.register');
    }



    public function store(Request $request)
    {

        try {

            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'second_name' => ['required', 'string', 'max:255'],
                'third_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'national_id' => ['required', 'unique:users', new PalestinianID],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $fullName = $request->first_name . ' ' . $request->second_name . ' ' . $request->third_name . ' ' . $request->last_name;


            $user = User::create([
                'name' => $fullName,
                'national_id' => $request->national_id,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('user');




            event(new Registered($user));
            Auth::login($user);
            Alert::success(__('menu.success'), __('menu.account_created'));
            session()->forget('url.intended');
            return redirect()->intended('user-management/users/'.$user->id);
        }catch (\Exception $exception){

            Alert::error('Error', $exception->getMessage());
            return back();

        }




    }
}
