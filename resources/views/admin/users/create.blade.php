@extends('layouts.admin')

@section('title', 'Thêm Người dùng')
@section('page-title', 'Thêm Người dùng')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Thông tin người dùng</h2>
            <p class="text-sm text-gray-500 mt-1">Điền thông tin để tạo người dùng mới</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Họ và tên <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Mật khẩu <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required
                       minlength="8"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Mật khẩu phải có ít nhất 8 ký tự</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Xác nhận mật khẩu <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required
                       minlength="8"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Trạng thái tài khoản <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        required
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Chưa kích hoạt</option>
                    <option value="locked" {{ old('status') === 'locked' ? 'selected' : '' }}>Đã khóa</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">
                    <span class="font-medium">Hoạt động:</span> Tài khoản có thể đăng nhập<br>
                    <span class="font-medium">Chưa kích hoạt:</span> Tài khoản chưa được kích hoạt<br>
                    <span class="font-medium">Đã khóa:</span> Tài khoản bị khóa, không thể đăng nhập
                </p>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Verified -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="email_verified" 
                           name="email_verified" 
                           value="1"
                           {{ old('email_verified') ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_verified" class="ml-2 text-sm text-gray-700">
                        Đánh dấu email đã được xác thực
                    </label>
                </div>
            </div>

            <!-- Roles -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Vai trò
                </label>
                @if($roles->isEmpty())
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">Chưa có vai trò nào trong hệ thống.</p>
                        <a href="{{ route('admin.roles.create') }}" class="mt-2 text-sm text-blue-600 hover:text-blue-700 inline-block">
                            Tạo vai trò mới
                        </a>
                    </div>
                @else
                    <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-300 rounded-lg p-4">
                        @foreach($roles as $role)
                        <label class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition-colors">
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->id }}"
                                   {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                @if($role->description)
                                <div class="text-xs text-gray-500 mt-1">{{ $role->description }}</div>
                                @endif
                                <div class="mt-1 flex items-center gap-2">
                                    <code class="text-xs text-gray-400">{{ $role->slug }}</code>
                                    <span class="text-xs text-gray-500">•</span>
                                    <span class="text-xs text-gray-500">{{ $role->permissions()->count() }} quyền</span>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Chọn một hoặc nhiều vai trò cho người dùng này</p>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Tạo người dùng
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

