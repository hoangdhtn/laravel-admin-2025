@extends('layouts.admin')

@section('title', 'Chỉnh sửa Người dùng')
@section('page-title', 'Chỉnh sửa Người dùng')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Thông tin người dùng</h2>
            <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin người dùng</p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Họ và tên <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}"
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
                       value="{{ old('email', $user->email) }}"
                       required
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Mật khẩu mới
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       minlength="8"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Để trống nếu không muốn thay đổi mật khẩu</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Xác nhận mật khẩu mới
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       minlength="8"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email Verified -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="email_verified" 
                           name="email_verified" 
                           value="1"
                           {{ old('email_verified', $user->email_verified_at) ? 'checked' : '' }}
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
                                   {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
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

            <!-- Created At Info -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="text-sm text-gray-600">
                    <p><span class="font-medium">Ngày tạo:</span> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    @if($user->updated_at)
                    <p class="mt-1"><span class="font-medium">Cập nhật lần cuối:</span> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

