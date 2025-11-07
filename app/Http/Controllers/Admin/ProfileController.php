<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('roles');
        
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('success', 'Thông tin hồ sơ đã được cập nhật thành công!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:'.((int) Setting::get('password_min_length', 8))],
        ]);

        // Apply password policy
        $passwordRules = [];
        if (Setting::get('password_require_mixed')) {
            $passwordRules[] = 'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/';
        }
        if (Setting::get('password_require_number')) {
            $passwordRules[] = 'regex:/^(?=.*\d).+$/';
        }
        if (Setting::get('password_require_symbol')) {
            $passwordRules[] = 'regex:/^(?=.*[^\w\s]).+$/';
        }

        if (!empty($passwordRules)) {
            $request->validate(['password' => $passwordRules]);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->boolean('logout_others')) {
            Auth::logoutOtherDevices($request->password);
        }

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048', 'dimensions:max_width=1000,max_height=1000'],
        ]);

        $user = $request->user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return back()->with('success', 'Ảnh đại diện đã được cập nhật thành công!');
    }

    /**
     * Remove the user's avatar.
     */
    public function removeAvatar(Request $request)
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Ảnh đại diện đã được xóa!');
    }
}
