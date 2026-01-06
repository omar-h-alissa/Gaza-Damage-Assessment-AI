<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/reset-password/reset-password.js');
        return view('pages.auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            // استخدام الترجمة هنا
            Alert::error(__('menu.error'), __('menu.phone_invalid'));
            return back();
        }

        return send_otb_whatsapp($user->phone);
    }

    public function verify_otp(Request $request)
    {
        try {
            $submitted_token = $request->otp;
            $user_phone_number = $request->phone;

            if (!$submitted_token || !$user_phone_number) {
                Alert::error(__('menu.error'), __('menu.token_phone_required'));
                return back(); // أضفت return هنا لمنع استكمال الكود
            }

            $reset_record = DB::table('password_reset_tokens')
                ->where('phone', $user_phone_number)
                ->where('token', $submitted_token)
                ->first();

            if (!$reset_record) {
                Alert::error(__('menu.error'), __('menu.invalid_code'));
                return back();
            }

            $created_at = $reset_record->created_at;
            $expiration_time = now()->subMinutes(5);

            if ($created_at < $expiration_time) {
                DB::table('password_reset_tokens')->where('phone', $user_phone_number)->delete();
                Alert::error(__('menu.error'), __('menu.code_expired'));
                return back();
            }

            DB::table('password_reset_tokens')->where('phone', $user_phone_number)->delete();
            $temporary_session_token = Str::random(60);

            return view('pages.auth.reset-password', [
                'token' => $temporary_session_token,
                'phone' => $user_phone_number,
            ]);
        } catch (\Exception $exception) {
            Alert::error(__('menu.error'), __('menu.general_error'));
            return back();
        }
    }


}
