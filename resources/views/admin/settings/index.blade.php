@extends('layouts.admin')

@section('title', 'Cài đặt')
@section('page-title', 'Cài đặt')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Tài khoản & Bảo mật -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Đổi mật khẩu</h2>
            <form method="POST" action="{{ route('admin.settings.password') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Mật khẩu mới</label>
                        <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex items-center">
                    <input id="logout_others" type="checkbox" name="logout_others" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <label for="logout_others" class="ml-2 text-sm text-gray-700">Đăng xuất khỏi các thiết bị khác</label>
                </div>
                <div>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cập nhật mật khẩu</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Xác thực 2 bước (2FA)</h2>
            <form method="POST" action="{{ route('admin.settings.two-factor') }}" class="flex items-center justify-between">
                @csrf
                <div class="text-sm text-gray-700">Bật/tắt yêu cầu mã xác thực khi đăng nhập</div>
                <div>
                    <select name="enabled" class="border border-gray-300 rounded-lg px-3 py-2">
                        <option value="1">Bật</option>
                        <option value="0">Tắt</option>
                    </select>
                    <button class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu</button>
                </div>
            </form>
            <p class="mt-2 text-xs text-gray-500">Mặc định dùng mã xác thực qua email (OTP 6 số) khi bật 2FA.</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quản lý phiên đăng nhập</h2>
            <form method="POST" action="{{ route('admin.settings.logout-others') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nhập mật khẩu hiện tại để đăng xuất tất cả thiết bị khác</label>
                    <input type="password" name="current_password" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Đăng xuất thiết bị khác</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Trạng thái tài khoản</h2>
            <form method="POST" action="{{ route('admin.settings.account-status') }}" class="flex items-center space-x-3">
                @csrf
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Chưa kích hoạt</option>
                    <option value="locked">Đã khóa</option>
                </select>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cập nhật</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Chính sách mật khẩu</h2>
            <form method="POST" action="{{ route('admin.settings.password-policy') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Độ dài tối thiểu</label>
                    <input type="number" min="6" max="64" name="password_min_length" value="{{ $settings['password_min_length'] }}" class="w-32 border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center text-sm"><input type="checkbox" name="password_require_mixed" value="1" class="mr-2" {{ $settings['password_require_mixed'] ? 'checked' : '' }}> Chữ hoa + chữ thường</label>
                    <label class="inline-flex items-center text-sm"><input type="checkbox" name="password_require_number" value="1" class="mr-2" {{ $settings['password_require_number'] ? 'checked' : '' }}> Ký tự số</label>
                    <label class="inline-flex items-center text-sm"><input type="checkbox" name="password_require_symbol" value="1" class="mr-2" {{ $settings['password_require_symbol'] ? 'checked' : '' }}> Ký tự đặc biệt</label>
                </div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu chính sách</button>
            </form>
        </div>
    </div>

    <!-- Giao diện & Hiển thị -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Logo, Tên hệ thống & Favicon</h2>
            <form method="POST" action="{{ route('admin.settings.branding') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Tên hệ thống</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Logo</label>
                    <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-700">
                    @if($settings['logo_path'])
                        <img src="{{ $settings['logo_path'] }}" alt="Logo" class="mt-2 h-12">
                    @endif
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Favicon</label>
                    <input type="file" name="favicon" accept="image/*" class="block w-full text-sm text-gray-700">
                    @if($settings['favicon_path'])
                        <img src="{{ $settings['favicon_path'] }}" alt="Favicon" class="mt-2 h-8">
                    @endif
                </div>
                <div>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


