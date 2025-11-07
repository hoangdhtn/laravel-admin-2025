<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => Setting::get('app_name', config('app.name', 'Laravel')),
            'logo_path' => Setting::get('logo_path'),
            'favicon_path' => Setting::get('favicon_path'),
            'password_min_length' => (int) Setting::get('password_min_length', 8),
            'password_require_mixed' => (bool) Setting::get('password_require_mixed', false),
            'password_require_number' => (bool) Setting::get('password_require_number', false),
            'password_require_symbol' => (bool) Setting::get('password_require_symbol', false),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:'.((int) Setting::get('password_min_length', 8))],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->boolean('logout_others')) {
            Auth::logoutOtherDevices($request->password);
        }

        return back()->with('success', 'Đã đổi mật khẩu thành công.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        $user = $request->user();
        $user->two_factor_enabled = $request->boolean('enabled');
        if (! $user->two_factor_enabled) {
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
        }
        $user->save();

        return back()->with('success', 'Đã cập nhật xác thực 2 bước.');
    }

    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);
        Auth::logoutOtherDevices($request->current_password);
        return back()->with('success', 'Đã đăng xuất khỏi các thiết bị khác.');
    }

    public function updateAccountStatus(Request $request)
    {
        $request->validate([
            'status' => ['required', Rule::in(['active','inactive','locked'])],
        ]);
        $user = $request->user();
        $user->status = $request->status;
        $user->save();
        return back()->with('success', 'Đã cập nhật trạng thái tài khoản.');
    }

    public function updatePasswordPolicy(Request $request)
    {
        $request->validate([
            'password_min_length' => ['required', 'integer', 'min:6', 'max:64'],
            'password_require_mixed' => ['nullable', 'boolean'],
            'password_require_number' => ['nullable', 'boolean'],
            'password_require_symbol' => ['nullable', 'boolean'],
        ]);

        Setting::set('password_min_length', $request->password_min_length);
        Setting::set('password_require_mixed', $request->boolean('password_require_mixed'));
        Setting::set('password_require_number', $request->boolean('password_require_number'));
        Setting::set('password_require_symbol', $request->boolean('password_require_symbol'));

        return back()->with('success', 'Đã cập nhật chính sách mật khẩu.');
    }

    public function updateBranding(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:1024'],
        ]);

        Setting::set('app_name', $validated['app_name']);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/settings', 'public');
            Setting::set('logo_path', Storage::disk('public')->url($path));
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('uploads/settings', 'public');
            Setting::set('favicon_path', Storage::disk('public')->url($path));
        }

        return back()->with('success', 'Đã cập nhật giao diện & hiển thị.');
    }
}
