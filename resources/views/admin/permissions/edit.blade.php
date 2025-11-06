@extends('layouts.admin')

@section('title', 'Chỉnh sửa Quyền')
@section('page-title', 'Chỉnh sửa Quyền')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Thông tin quyền</h2>
            <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin quyền</p>
        </div>

        <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Tên quyền <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $permission->name) }}"
                       required
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                    Slug
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug', $permission->slug) }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Slug sẽ được tạo tự động từ tên nếu để trống</p>
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Group -->
            <div class="mb-6">
                <label for="group" class="block text-sm font-medium text-gray-700 mb-2">
                    Nhóm quyền
                </label>
                <input type="text" 
                       id="group" 
                       name="group" 
                       value="{{ old('group', $permission->group) }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('group') border-red-500 @enderror">
                @error('group')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Mô tả
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $permission->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $permission->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">
                        Kích hoạt quyền này
                    </label>
                </div>
            </div>

            <!-- Info -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="text-sm text-gray-600">
                    <p><span class="font-medium">Ngày tạo:</span> {{ $permission->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mt-1"><span class="font-medium">Cập nhật lần cuối:</span> {{ $permission->updated_at->format('d/m/Y H:i') }}</p>
                    <p class="mt-1"><span class="font-medium">Số vai trò:</span> {{ $permission->roles()->count() }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.permissions.index') }}" 
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

