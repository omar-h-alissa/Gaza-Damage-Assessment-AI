<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.user-management.users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        // Validate the input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'third_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'details' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle avatar upload if exists
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        } elseif ($request->input('avatar_remove')) {
            $user->avatar = null;
        }

        // Update user basic info
        $user->phone = $validated['phone'];
        $user->family_members = 7;

        // Update the full name column
        $fullName = trim(implode(' ', [
            $validated['first_name'],
            $validated['second_name'] ?? '',
            $validated['third_name'] ?? '',
            $validated['last_name'],
        ]));

        $user->name = $fullName;

        // Update the address as single column (concatenate parts)
        $user->address = implode(' - ', [
            $validated['area'] ?? '',
            $validated['city'] ?? '',
            $validated['street'] ?? '',
            $validated['details'] ?? '',
        ]);



        // Save the user
        $user->save();

        // Redirect back with success message
        return redirect()->route('user-management.users.show', $user)
            ->with('success', 'User details updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function updatePassword(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'current_password' => ['required', 'current_password'], // يتحقق تلقائياً من كلمة المرور الحالية
            'new_password'     => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.current_password' => __('كلمة المرور الحالية غير صحيحة'),
            'new_password.confirmed'            => __('تأكيد كلمة المرور غير متطابق'),
        ]);

        // 2. التحديث
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message' => __('تم تحديث كلمة المرور بنجاح')]);
    }
}
